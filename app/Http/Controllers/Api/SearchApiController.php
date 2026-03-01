<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\SearchLog;
use App\Models\PopularSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SearchApiController extends Controller
{
    /**
     * Recherche AJAX avec pagination
     */
    public function search(Request $request)
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

        // Log de la recherche pour les analytics
        if (!empty($query)) {
            $this->logSearch($request, $query, $products->total());
        }

        // Formatage des résultats pour l'API
        $formattedProducts = $products->map(function ($product) {
            $mainImage = $product->getFirstMediaUrl('products', 'main');
            $thumbImage = $product->getFirstMediaUrl('products', 'thumb');
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'short_description' => $product->short_description,
                'price' => number_format($product->price, 0, ',', ' '),
                'price_raw' => $product->price,
                'brand' => $product->brand,
                'condition' => $product->condition,
                'condition_label' => Product::getAvailableConditions()[$product->condition] ?? $product->condition,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'images' => [
                    'main' => $mainImage ?: asset('images/no-image.jpg'),
                    'thumb' => $thumbImage ?: asset('images/no-image.jpg'),
                ],
                'url' => route('products.show', $product->slug),
                'whatsapp_url' => $product->whatsapp_url,
                'stock' => $product->stock,
                'is_featured' => $product->is_featured,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'has_more' => $products->hasMorePages(),
            ],
            'filters' => [
                'query' => $query,
                'category' => $categoryId,
                'brand' => $brand,
                'condition' => $condition,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'sort' => $sortBy,
            ],
        ]);
    }

    /**
     * Autocomplétion
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'suggestions' => []
            ]);
        }

        $suggestions = Cache::remember("autocomplete_{$query}", 300, function () use ($query) {
            // Suggestions de produits
            $productSuggestions = Product::active()
                ->where('name', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get(['id', 'name', 'slug'])
                ->map(function ($product) {
                    return [
                        'type' => 'product',
                        'text' => $product->name,
                        'url' => route('products.show', $product->slug)
                    ];
                });

            // Suggestions de marques
            $brandSuggestions = Product::active()
                ->where('brand', 'LIKE', "%{$query}%")
                ->whereNotNull('brand')
                ->distinct()
                ->limit(3)
                ->pluck('brand')
                ->map(function ($brand) {
                    return [
                        'type' => 'brand',
                        'text' => $brand,
                        'url' => route('search.index', ['q' => $brand])
                    ];
                });

            // Suggestions de recherches populaires
            $popularSuggestions = PopularSearch::where('query', 'LIKE', "%{$query}%")
                ->popular(3)
                ->get(['query'])
                ->map(function ($search) {
                    return [
                        'type' => 'popular',
                        'text' => $search->query,
                        'url' => route('search.index', ['q' => $search->query])
                    ];
                });

            return $productSuggestions
                ->concat($brandSuggestions)
                ->concat($popularSuggestions)
                ->take(10);
        });

        return response()->json([
            'success' => true,
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Obtient les filtres disponibles
     */
    public function getFilters()
    {
        $categories = Cache::remember('search_categories', 3600, function () {
            return Category::active()
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'products_count' => $category->products()->active()->count()
                    ];
                });
        });

        $brands = Cache::remember('search_brands', 3600, function () {
            return collect(Product::getAvailableBrands())
                ->map(function ($brand) {
                    return [
                        'value' => $brand,
                        'label' => $brand,
                        'products_count' => Product::active()->where('brand', $brand)->count()
                    ];
                });
        });

        $conditions = collect(Product::getAvailableConditions())
            ->map(function ($label, $value) {
                return [
                    'value' => $value,
                    'label' => $label,
                    'products_count' => Product::active()->where('condition', $value)->count()
                ];
            })
            ->values();

        $priceRanges = [
            ['min' => 0, 'max' => 50000, 'label' => 'Moins de 50 000 FCFA'],
            ['min' => 50000, 'max' => 100000, 'label' => '50 000 - 100 000 FCFA'],
            ['min' => 100000, 'max' => 200000, 'label' => '100 000 - 200 000 FCFA'],
            ['min' => 200000, 'max' => 500000, 'label' => '200 000 - 500 000 FCFA'],
            ['min' => 500000, 'max' => null, 'label' => 'Plus de 500 000 FCFA'],
        ];

        return response()->json([
            'success' => true,
            'filters' => [
                'categories' => $categories,
                'brands' => $brands,
                'conditions' => $conditions,
                'price_ranges' => $priceRanges,
            ]
        ]);
    }

    /**
     * Obtient les recherches populaires
     */
    public function getPopularSearches()
    {
        $popularSearches = Cache::remember('api_popular_searches', 3600, function () {
            return PopularSearch::popular(10)
                ->get(['query', 'search_count'])
                ->map(function ($search) {
                    return [
                        'query' => $search->query,
                        'count' => $search->search_count,
                        'url' => route('search.index', ['q' => $search->query])
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'popular_searches' => $popularSearches
        ]);
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
}
