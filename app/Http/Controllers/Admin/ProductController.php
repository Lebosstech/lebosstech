<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'media']);
        
        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filtres
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }
        
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            }
        }
        
        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        $allowedSorts = ['name', 'price', 'stock', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }
        
        $products = $query->paginate(20)->withQueryString();
        $categories = Category::active()->orderBy('name')->get();
        
        // Statistiques
        $stats = [
            'total' => Product::count(),
            'active' => Product::where('is_active', true)->count(),
            'inactive' => Product::where('is_active', false)->count(),
            'featured' => Product::where('is_featured', true)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'low_stock' => Product::where('stock', '>', 0)->where('stock', '<=', 5)->count(),
        ];
        
        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'condition' => 'nullable|in:neuf,excellent,tres_bon,bon,correct',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
            'spec_keys' => 'nullable|array',
            'spec_keys.*' => 'string|max:100',
            'spec_values' => 'nullable|array',
            'spec_values.*' => 'string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'track_stock' => 'boolean',
            'allow_backorder' => 'boolean',
            'notify_low_stock' => 'boolean',
            'is_draft' => 'boolean',
            'location' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:50',
            'return_policy' => 'nullable|string|max:50',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date|after:available_from',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        
        // Générer le slug
        $data['slug'] = $this->generateUniqueSlug($request->name);
        
        // Gestion des booléens
        $data['is_active'] = $request->has('is_active') && !$request->has('is_draft');
        $data['is_featured'] = $request->has('is_featured');
        $data['track_stock'] = $request->has('track_stock');
        $data['allow_backorder'] = $request->has('allow_backorder');
        $data['notify_low_stock'] = $request->has('notify_low_stock');
        $data['is_draft'] = $request->has('is_draft');
        
        // Traitement des spécifications
        if ($request->has('spec_keys') && $request->has('spec_values')) {
            $keys = $request->spec_keys;
            $values = $request->spec_values;
            $specifications = [];
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $specifications[$keys[$i]] = $values[$i];
                }
            }
            
            $data['specifications'] = $specifications;
        }
        
        // Calculer la marge si prix de revient fourni
        if ($request->filled('cost_price') && $request->filled('price')) {
            $data['margin_amount'] = $request->price - $request->cost_price;
            $data['margin_percent'] = $request->price > 0 ? (($request->price - $request->cost_price) / $request->price) * 100 : 0;
        }
        
        // Calculer le pourcentage de remise
        if ($request->filled('compare_price') && $request->filled('price') && $request->compare_price > $request->price) {
            $data['discount_percent'] = (($request->compare_price - $request->price) / $request->compare_price) * 100;
        }
        
        // Générer les dimensions du colis
        if ($request->filled(['length', 'width', 'height'])) {
            $data['package_dimensions'] = [
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'weight' => $request->weight ?? 0
            ];
        }

        $product = Product::create($data);

        // Gestion des images avec ordre
        if ($request->hasFile('images')) {
            $this->handleImageUpload($product, $request->file('images'));
        }
        
        // TODO: Ajouter la gestion des alertes de stock
        // if ($request->has('notify_low_stock') && $request->stock <= ($request->min_stock ?? 5)) {
        //     $this->createStockAlert($product);
        // }
        
        $message = $request->has('is_draft') ? 'Brouillon sauvegardé avec succès.' : 'Produit créé avec succès.';
        $redirect = $request->has('is_draft') ? 'admin.products.edit' : 'admin.products.index';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message, 'product_id' => $product->id]);
        }

        return redirect()->route($redirect, $request->has('is_draft') ? $product : [])
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'media']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        $product->load(['category', 'media']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Show the enhanced form for editing the specified resource.
     */
    public function editEnhanced(Product $product)
    {
        $categories = Category::active()->orderBy('name')->get();
        $product->load(['category', 'media']);
        
        // Récupération directe des images pour contourner le problème de cache
        $productImages = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('model_type', 'App\\Models\\Product')
            ->where('model_id', $product->id)
            ->where('collection_name', 'images')
            ->get();
        
        return view('admin.products.edit_enhanced', compact('product', 'categories', 'productImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:100',
            'condition' => 'nullable|in:neuf,excellent,tres_bon,bon,correct',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
            'spec_keys' => 'nullable|array',
            'spec_keys.*' => 'string|max:100',
            'spec_values' => 'nullable|array',
            'spec_values.*' => 'string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer|exists:media,id',
            'track_stock' => 'boolean',
            'allow_backorder' => 'boolean',
            'notify_low_stock' => 'boolean',
            'is_draft' => 'boolean',
            'location' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:50',
            'return_policy' => 'nullable|string|max:50',
            'available_from' => 'nullable|date',
        ]);

        $data = $request->except(['images', 'remove_images', 'spec_keys', 'spec_values']);
        
        // Générer un nouveau slug si le nom a changé
        if ($product->name !== $request->name) {
            $data['slug'] = $this->generateUniqueSlug($request->name, $product->id);
        }
        
        // Gérer les booléens
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_draft'] = $request->has('is_draft');
        $data['track_stock'] = $request->has('track_stock');
        $data['allow_backorder'] = $request->has('allow_backorder');
        $data['notify_low_stock'] = $request->has('notify_low_stock');
        
        // Gérer les spécifications
        if ($request->has('spec_keys') && $request->has('spec_values')) {
            $keys = $request->spec_keys;
            $values = $request->spec_values;
            $specifications = [];
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $specifications[$keys[$i]] = $values[$i];
                }
            }
            
            $data['specifications'] = $specifications;
        }
        
        // Gérer les dimensions du colis
        if ($request->filled(['length', 'width', 'height'])) {
            $data['package_dimensions'] = [
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'weight' => $request->weight ?? 0
            ];
        }

        $product->update($data);

        // Supprimer les images marquées pour suppression
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $mediaId) {
                $media = $product->getMedia('images')->where('id', $mediaId)->first();
                if ($media) {
                    $media->delete();
                }
            }
        }

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            $this->handleImageUpload($product, $request->file('images'));
        }

        $message = $request->has('is_draft') ? 'Brouillon sauvegardé avec succès.' : 'Produit modifié avec succès.';
        $redirect = $request->has('is_draft') ? 'admin.products.edit-enhanced' : 'admin.products.index';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route($redirect, $request->has('is_draft') ? $product : [])
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->clearMediaCollection('images');
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
    
    /**
     * Dupliquer un produit
     */
    public function duplicate(Product $product)
    {
        $newProduct = $product->replicate([
            'slug',
            'sku',
            'created_at',
            'updated_at'
        ]);
        
        $newProduct->name = $product->name . ' (Copie)';
        $newProduct->slug = $this->generateUniqueSlug($newProduct->name);
        $newProduct->sku = $this->generateUniqueSku();
        $newProduct->is_active = false; // Désactiver par défaut
        $newProduct->save();
        
        // Copier les images
        foreach ($product->getMedia('images') as $media) {
            $newProduct->addMediaFromUrl($media->getUrl())
                ->toMediaCollection('images');
        }
        
        return redirect()->route('admin.products.edit', $newProduct)
            ->with('success', 'Produit dupliqué avec succès. N\'oubliez pas de l\'activer.');
    }
    
    /**
     * Actions en lot
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);
        
        $products = Product::whereIn('id', $request->products);
        $count = $products->count();
        
        switch ($request->action) {
            case 'activate':
                $products->update(['is_active' => true]);
                $message = "{$count} produit(s) activé(s) avec succès.";
                break;
                
            case 'deactivate':
                $products->update(['is_active' => false]);
                $message = "{$count} produit(s) désactivé(s) avec succès.";
                break;
                
            case 'feature':
                $products->update(['is_featured' => true]);
                $message = "{$count} produit(s) mis en vedette avec succès.";
                break;
                
            case 'unfeature':
                $products->update(['is_featured' => false]);
                $message = "{$count} produit(s) retiré(s) de la vedette avec succès.";
                break;
                
            case 'delete':
                foreach ($products->get() as $product) {
                    $product->clearMediaCollection('images');
                    $product->delete();
                }
                $message = "{$count} produit(s) supprimé(s) avec succès.";
                break;
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }
    
    /**
     * Supprimer une image
     */
    public function deleteImage(Product $product, $mediaId)
    {
        $media = $product->getMedia('images')->where('id', $mediaId)->first();
        
        if ($media) {
            $media->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    /**
     * Réorganiser les images
     */
    public function reorderImages(Product $product, Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:media,id',
        ]);
        
        foreach ($request->order as $index => $mediaId) {
            $media = $product->getMedia('images')->where('id', $mediaId)->first();
            if ($media) {
                $media->order_column = $index + 1;
                $media->save();
            }
        }
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Générer un slug unique
     */
    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $query = Product::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Générer un SKU unique
     */
    private function generateUniqueSku()
    {
        do {
            $sku = 'LBT-' . strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());
        
        return $sku;
    }
    
    /**
     * Gérer l'upload d'images
     */
    private function handleImageUpload(Product $product, $images)
    {
        foreach ($images as $index => $image) {
            $product->addMedia($image)
                ->toMediaCollection('images');
        }
    }
} 