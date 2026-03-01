<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PopularSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'search_count',
        'results_count',
        'last_searched_at',
    ];

    protected $casts = [
        'search_count' => 'integer',
        'results_count' => 'integer',
        'last_searched_at' => 'datetime',
    ];

    /**
     * Incrémente le compteur de recherche
     */
    public static function incrementSearch(string $query, int $resultsCount = 0): self
    {
        $popularSearch = self::updateOrCreate(
            ['query' => $query],
            [
                'results_count' => $resultsCount,
                'last_searched_at' => now(),
            ]
        );
        
        $popularSearch->increment('search_count');
        
        return $popularSearch;
    }

    /**
     * Scope pour les recherches populaires
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->orderByDesc('search_count')
            ->orderByDesc('last_searched_at')
            ->limit($limit);
    }

    /**
     * Scope pour les recherches récentes
     */
    public function scopeRecentlySearched($query, $days = 7)
    {
        return $query->where('last_searched_at', '>=', now()->subDays($days));
    }
}
