<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'tax_rate',
        'stock',
        'min_stock',
        'max_stock',
        'category_id',
        'brand',
        'condition',
        'weight',
        'length',
        'width',
        'height',
        'specifications',
        'is_active',
        'is_featured',
        'is_draft',
        'track_stock',
        'allow_backorder',
        'notify_low_stock',
        'meta_title',
        'meta_description',
        'tags',
        'whatsapp_clicks',
        'margin_amount',
        'margin_percent',
        'discount_percent',
        'package_dimensions'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'margin_amount' => 'decimal:2',
        'margin_percent' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'specifications' => 'array',
        'package_dimensions' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_draft' => 'boolean',
        'track_stock' => 'boolean',
        'allow_backorder' => 'boolean',
        'notify_low_stock' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('main')
            ->width(800)
            ->height(600)
            ->sharpen(10);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'LBT-' . strtoupper(Str::random(8));
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Recherche full-text dans nom, description et spécifications
     */
    public function scopeSearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $terms = explode(' ', $searchTerm);
        
        return $query->where(function ($q) use ($terms) {
            foreach ($terms as $term) {
                $q->where(function ($subQuery) use ($term) {
                    $subQuery->where('name', 'LIKE', "%{$term}%")
                           ->orWhere('short_description', 'LIKE', "%{$term}%")
                           ->orWhere('description', 'LIKE', "%{$term}%")
                           ->orWhere('brand', 'LIKE', "%{$term}%")
                           ->orWhere('sku', 'LIKE', "%{$term}%")
                           ->orWhereRaw('JSON_EXTRACT(specifications, "$") LIKE ?', ["%{$term}%"]);
                });
            }
        });
    }

    /**
     * Filtre par prix
     */
    public function scopePriceRange(Builder $query, ?float $minPrice, ?float $maxPrice): Builder
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }

    /**
     * Filtre par marque
     */
    public function scopeByBrand(Builder $query, ?string $brand): Builder
    {
        if ($brand) {
            return $query->where('brand', $brand);
        }
        
        return $query;
    }

    /**
     * Filtre par catégorie
     */
    public function scopeByCategory(Builder $query, ?int $categoryId): Builder
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        
        return $query;
    }

    /**
     * Filtre par état/condition
     */
    public function scopeByCondition(Builder $query, ?string $condition): Builder
    {
        if ($condition) {
            return $query->where('condition', $condition);
        }
        
        return $query;
    }

    /**
     * Tri par pertinence (basé sur la correspondance du terme de recherche)
     */
    public function scopeOrderByRelevance(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        return $query->selectRaw('*, 
            (CASE 
                WHEN name LIKE ? THEN 10
                WHEN name LIKE ? THEN 8
                WHEN short_description LIKE ? THEN 6
                WHEN description LIKE ? THEN 4
                WHEN brand LIKE ? THEN 3
                ELSE 1
            END) as relevance_score', [
                $searchTerm,
                "%{$searchTerm}%",
                "%{$searchTerm}%",
                "%{$searchTerm}%",
                "%{$searchTerm}%"
            ])
            ->orderBy('relevance_score', 'desc')
            ->orderBy('is_featured', 'desc');
    }

    /**
     * Obtient les marques disponibles
     */
    public static function getAvailableBrands(): array
    {
        return self::active()
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Obtient les conditions disponibles
     */
    public static function getAvailableConditions(): array
    {
        return [
            'neuf' => 'Neuf',
            'excellent' => 'Excellent état',
            'tres_bon' => 'Très bon état',
            'bon' => 'Bon état',
            'correct' => 'État correct'
        ];
    }

    /**
     * Produits similaires pour les suggestions
     */
    public function getSimilarProducts(int $limit = 4)
    {
        return self::active()
            ->where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('category_id', $this->category_id)
                      ->orWhere('brand', $this->brand);
            })
            ->inStock()
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getWhatsAppUrlAttribute()
    {
        $message = "Bonjour, je suis intéressé par le produit {$this->name}";
        return "https://wa.me/2250566821609?text=" . urlencode($message);
    }

    public function incrementWhatsAppClicks()
    {
        $this->increment('whatsapp_clicks');
    }
}
