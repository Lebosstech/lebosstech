<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['category', 'media']);
        
        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filtrage par prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filtrage par stock
        if ($request->filled('in_stock') && $request->in_stock) {
            $query->inStock();
        }
        
        // Filtrage par produits vedettes
        if ($request->filled('featured') && $request->featured) {
            $query->where('is_featured', true);
        }
        
        // Recherche avancée
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('short_description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Tri
        $sort = $request->get('sort', '');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popular':
                $query->orderBy('whatsapp_clicks', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12);
        
        // Récupérer les catégories avec le nombre de produits
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('name')
            ->get();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function show($slug)
    {
        $product = Product::active()->with(['category', 'media'])->where('slug', $slug)->firstOrFail();
        
        // Récupération directe des images pour contourner le problème de cache
        $productImages = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\Product')
            ->where('model_id', $product->id)
            ->where('collection_name', 'images')
            ->orderBy('id')
            ->get();
        
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts', 'productImages'));
    }
    
    public function category($slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();
        $products = Product::active()
            ->where('category_id', $category->id)
            ->with(['category', 'media'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('name')
            ->get();
        
        return view('products.category', compact('category', 'products', 'categories'));
    }
    
    public function whatsappClick(Product $product)
    {
        $product->incrementWhatsAppClicks();
        
        return redirect($product->whatsapp_url);
    }
    
    /**
     * Aperçu rapide d'un produit (AJAX)
     */
    public function quickView(Product $product): JsonResponse
    {
        $product->load(['category', 'media']);
        
        $html = view('products.partials.quick-view', compact('product'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'formatted_price' => number_format($product->price, 0, ',', ' ') . ' FCFA',
                'stock' => $product->stock,
                'category' => $product->category->name,
                'image' => $product->getFirstMediaUrl('images', 'thumb'),
                'slug' => $product->slug,
                'whatsapp_url' => $product->whatsapp_url
            ]
        ]);
    }
    
    /**
     * Recherche AJAX pour l'autocomplétion
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('short_description', 'like', '%' . $query . '%');
            })
            ->with('category')
            ->limit(10)
            ->get(['id', 'name', 'price', 'slug', 'category_id']);
        
        return response()->json($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->price, 0, ',', ' ') . ' FCFA',
                'category' => $product->category->name,
                'url' => route('products.show', $product->slug),
                'image' => $product->getFirstMediaUrl('images', 'thumb')
            ];
        }));
    }
    
    /**
     * Comparaison de produits
     */
    public function compare(Request $request): JsonResponse
    {
        $productIds = $request->get('products', []);
        
        if (empty($productIds) || count($productIds) > 3) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez sélectionner 2 à 3 produits pour la comparaison'
            ]);
        }
        
        $products = Product::active()
            ->whereIn('id', $productIds)
            ->with(['category', 'media'])
            ->get();
        
        $html = view('products.partials.compare', compact('products'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $products->count()
        ]);
    }
    
    /**
     * Produits similaires (recommandations)
     */
    public function similar(Product $product): JsonResponse
    {
        $similarProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->whereBetween('price', [
                $product->price * 0.5,
                $product->price * 1.5
            ])
            ->with(['category', 'media'])
            ->inRandomOrder()
            ->limit(6)
            ->get();
        
        return response()->json([
            'success' => true,
            'products' => $similarProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'formatted_price' => number_format($product->price, 0, ',', ' ') . ' FCFA',
                    'category' => $product->category->name,
                    'image' => $product->getFirstMediaUrl('images', 'thumb'),
                    'url' => route('products.show', $product->slug),
                    'stock' => $product->stock,
                    'in_stock' => $product->stock > 0
                ];
            })
        ]);
    }
    
    /**
     * Statistiques des produits pour les graphiques
     */
    public function stats(): JsonResponse
    {
        $totalProducts = Product::active()->count();
        $inStock = Product::active()->inStock()->count();
        $outOfStock = Product::active()->where('stock', '<=', 0)->count();
        $featured = Product::active()->where('is_featured', true)->count();
        
        $categoriesStats = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active();
            }])
            ->orderBy('products_count', 'desc')
            ->limit(10)
            ->get(['name', 'products_count']);
        
        $priceRanges = [
            'moins_50k' => Product::active()->where('price', '<', 50000)->count(),
            '50k_100k' => Product::active()->whereBetween('price', [50000, 100000])->count(),
            '100k_500k' => Product::active()->whereBetween('price', [100000, 500000])->count(),
            'plus_500k' => Product::active()->where('price', '>', 500000)->count(),
        ];
        
        return response()->json([
            'success' => true,
            'stats' => [
                'total_products' => $totalProducts,
                'in_stock' => $inStock,
                'out_of_stock' => $outOfStock,
                'featured' => $featured,
                'categories' => $categoriesStats,
                'price_ranges' => $priceRanges
            ]
        ]);
    }
}
