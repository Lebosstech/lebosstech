<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SearchLog;
use App\Models\PopularSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Page de recherche principale
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $categoryId = $request->get('category');
        $brand = $request->get('brand');
        $condition = $request->get('condition');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sortBy = $request->get('sort', 'relevance');
        $page = $request->get('page', 1);
        $perPage = 12;

        // Construction de la requête
        $productsQuery = Product::active()
            ->with(['category', 'media'])
            ->search($query)
            ->byCategory($categoryId)
            ->byBrand($brand)
            ->byCondition($condition)
            ->priceRange($minPrice, $maxPrice);

        // Tri
        switch ($sortBy) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'relevance':
            default:
                $productsQuery->orderByRelevance($query);
                break;
        }

        $products = $productsQuery->paginate($perPage);
        
        // Log de la recherche
        if (!empty($query)) {
            $this->logSearch($request, $query, $products->total());
        }

        // Données pour les filtres
        $categories = Category::active()->orderBy('name')->get();
        $brands = Product::getAvailableBrands();
        $conditions = Product::getAvailableConditions();
        
        // Recherches populaires
        $popularSearches = $this->getPopularSearches();
        
        // Suggestions "Vous pourriez aimer"
        $suggestions = $this->getSuggestions($query, $categoryId);

        return view('search.index', compact(
            'products',
            'query',
            'categoryId',
            'brand',
            'condition',
            'minPrice',
            'maxPrice',
            'sortBy',
            'categories',
            'brands',
            'conditions',
            'popularSearches',
            'suggestions'
        ));
    }

    /**
     * Autocomplétion pour la barre de recherche
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Cache::remember("autocomplete_{$query}", 300, function () use ($query) {
            // Suggestions basées sur les noms de produits
            $productSuggestions = Product::active()
                ->where('name', 'LIKE', "%{$query}%")
                ->limit(5)
                ->pluck('name')
                ->toArray();

            // Suggestions basées sur les marques
            $brandSuggestions = Product::active()
                ->where('brand', 'LIKE', "%{$query}%")
                ->distinct()
                ->limit(3)
                ->pluck('brand')
                ->filter()
                ->toArray();

            // Suggestions basées sur les recherches populaires
            $popularSuggestions = PopularSearch::where('query', 'LIKE', "%{$query}%")
                ->popular(3)
                ->pluck('query')
                ->toArray();

            return array_unique(array_merge($productSuggestions, $brandSuggestions, $popularSuggestions));
        });

        return response()->json($suggestions);
    }

    /**
     * Enregistre une recherche pour les analytics
     */
    private function logSearch(Request $request, string $query, int $resultsCount): void
    {
        $filters = [
            'category' => $request->get('category'),
            'brand' => $request->get('brand'),
            'condition' => $request->get('condition'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
        ];

        // Enlever les filtres vides
        $filters = array_filter($filters);

        SearchLog::create([
            'query' => $query,
            'filters' => $filters,
            'sort_by' => $request->get('sort', 'relevance'),
            'results_count' => $resultsCount,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => Auth::check() ? Auth::id() : null,
        ]);

        // Mettre à jour les recherches populaires
        PopularSearch::incrementSearch($query, $resultsCount);
    }

    /**
     * Obtient les recherches populaires
     */
    private function getPopularSearches(int $limit = 8): array
    {
        return Cache::remember('popular_searches', 3600, function () use ($limit) {
            return PopularSearch::popular($limit)->pluck('query')->toArray();
        });
    }

    /**
     * Obtient des suggestions basées sur la recherche actuelle
     */
    private function getSuggestions(?string $query, ?int $categoryId, int $limit = 8)
    {
        return Cache::remember("suggestions_{$query}_{$categoryId}", 1800, function () use ($query, $categoryId, $limit) {
            $suggestionsQuery = Product::active()
                ->with(['category', 'media'])
                ->inStock();

            if ($categoryId) {
                $suggestionsQuery->where('category_id', $categoryId);
            }

            if ($query) {
                // Produits de la même catégorie ou marque que les résultats de recherche
                $relatedProducts = Product::active()
                    ->search($query)
                    ->limit(3)
                    ->get();

                if ($relatedProducts->isNotEmpty()) {
                    $categories = $relatedProducts->pluck('category_id')->unique();
                    $brands = $relatedProducts->pluck('brand')->filter()->unique();

                    $suggestionsQuery->where(function ($q) use ($categories, $brands) {
                        $q->whereIn('category_id', $categories);
                        if ($brands->isNotEmpty()) {
                            $q->orWhereIn('brand', $brands);
                        }
                    });
                }
            }

            return $suggestionsQuery
                ->orderBy('is_featured', 'desc')
                ->orderBy('whatsapp_clicks', 'desc')
                ->limit($limit)
                ->get();
        });
    }
}
