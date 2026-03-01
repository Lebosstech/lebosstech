<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'filters',
        'sort_by',
        'results_count',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    protected $casts = [
        'filters' => 'array',
        'results_count' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour les recherches récentes
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope pour les recherches populaires
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->select('query')
            ->selectRaw('COUNT(*) as search_count')
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit($limit);
    }
}
