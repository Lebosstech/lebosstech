<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'metric_type',
        'revenue',
        'orders_count',
        'whatsapp_clicks',
        'average_order_value',
        'conversion_rate',
        'visitors',
        'page_views',
        'unique_visitors',
        'bounce_rate',
        'session_duration',
        'abidjan_visitors',
        'interior_visitors',
        'international_visitors',
        'products_viewed',
        'searches_count',
        'top_products',
        'top_categories',
        'top_search_terms',
        'organic_traffic',
        'avg_position',
        'indexed_pages',
        'keyword_positions',
    ];

    protected $casts = [
        'date' => 'date',
        'revenue' => 'decimal:2',
        'average_order_value' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
        'bounce_rate' => 'decimal:2',
        'avg_position' => 'decimal:2',
        'top_products' => 'array',
        'top_categories' => 'array',
        'top_search_terms' => 'array',
        'keyword_positions' => 'array',
    ];

    /**
     * Obtient les KPIs pour une période donnée
     */
    public static function getKPIs($startDate = null, $endDate = null, $metricType = 'daily')
    {
        $query = self::where('metric_type', $metricType);
        
        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }
        
        $data = $query->get();
        
        return [
            'total_revenue' => $data->sum('revenue'),
            'total_orders' => $data->sum('orders_count'),
            'total_whatsapp_clicks' => $data->sum('whatsapp_clicks'),
            'avg_order_value' => $data->avg('average_order_value'),
            'avg_conversion_rate' => $data->avg('conversion_rate'),
            'total_visitors' => $data->sum('visitors'),
            'total_page_views' => $data->sum('page_views'),
            'unique_visitors' => $data->sum('unique_visitors'),
            'avg_bounce_rate' => $data->avg('bounce_rate'),
            'avg_session_duration' => $data->avg('session_duration'),
            'abidjan_visitors' => $data->sum('abidjan_visitors'),
            'interior_visitors' => $data->sum('interior_visitors'),
            'international_visitors' => $data->sum('international_visitors'),
            'total_searches' => $data->sum('searches_count'),
            'organic_traffic' => $data->sum('organic_traffic'),
        ];
    }

    /**
     * Compare deux périodes
     */
    public static function comparePeriods($currentStart, $currentEnd, $previousStart, $previousEnd, $metricType = 'daily')
    {
        $current = self::getKPIs($currentStart, $currentEnd, $metricType);
        $previous = self::getKPIs($previousStart, $previousEnd, $metricType);
        
        $comparison = [];
        foreach ($current as $key => $value) {
            $previousValue = $previous[$key] ?? 0;
            $change = $previousValue > 0 ? (($value - $previousValue) / $previousValue) * 100 : 0;
            
            $comparison[$key] = [
                'current' => $value,
                'previous' => $previousValue,
                'change' => round($change, 2),
                'trend' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable')
            ];
        }
        
        return $comparison;
    }

    /**
     * Données pour graphiques d'évolution
     */
    public static function getChartData($metric, $startDate, $endDate, $metricType = 'daily')
    {
        return self::where('metric_type', $metricType)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get(['date', $metric])
            ->map(function ($item) use ($metric) {
                return [
                    'date' => $item->date->format('Y-m-d'),
                    'value' => $item->$metric
                ];
            });
    }

    /**
     * Top produits consolidés
     */
    public static function getTopProducts($startDate, $endDate, $limit = 10)
    {
        $analytics = self::whereBetween('date', [$startDate, $endDate])
            ->whereNotNull('top_products')
            ->get();
        
        $products = [];
        foreach ($analytics as $analytic) {
            foreach ($analytic->top_products as $product) {
                $id = $product['id'];
                if (!isset($products[$id])) {
                    $products[$id] = [
                        'id' => $id,
                        'name' => $product['name'],
                        'views' => 0,
                        'clicks' => 0
                    ];
                }
                $products[$id]['views'] += $product['views'] ?? 0;
                $products[$id]['clicks'] += $product['clicks'] ?? 0;
            }
        }
        
        return collect($products)
            ->sortByDesc('views')
            ->take($limit)
            ->values();
    }

    /**
     * Analyse géographique
     */
    public static function getGeographicAnalysis($startDate, $endDate)
    {
        $data = self::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                SUM(abidjan_visitors) as abidjan,
                SUM(interior_visitors) as interior,
                SUM(international_visitors) as international
            ')
            ->first();
        
        $total = $data->abidjan + $data->interior + $data->international;
        
        return [
            'abidjan' => [
                'count' => $data->abidjan,
                'percentage' => $total > 0 ? round(($data->abidjan / $total) * 100, 1) : 0
            ],
            'interior' => [
                'count' => $data->interior,
                'percentage' => $total > 0 ? round(($data->interior / $total) * 100, 1) : 0
            ],
            'international' => [
                'count' => $data->international,
                'percentage' => $total > 0 ? round(($data->international / $total) * 100, 1) : 0
            ],
            'total' => $total
        ];
    }

    /**
     * Enregistre ou met à jour les analytics du jour
     */
    public static function recordDaily($data, $date = null)
    {
        $date = $date ?: now()->toDateString();
        
        return self::updateOrCreate(
            [
                'date' => $date,
                'metric_type' => 'daily'
            ],
            $data
        );
    }

    /**
     * Génère les analytics hebdomadaires
     */
    public static function generateWeekly($startDate, $endDate)
    {
        $dailyData = self::where('metric_type', 'daily')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
        
        $weeklyData = [
            'date' => $endDate,
            'metric_type' => 'weekly',
            'revenue' => $dailyData->sum('revenue'),
            'orders_count' => $dailyData->sum('orders_count'),
            'whatsapp_clicks' => $dailyData->sum('whatsapp_clicks'),
            'average_order_value' => $dailyData->avg('average_order_value'),
            'conversion_rate' => $dailyData->avg('conversion_rate'),
            'visitors' => $dailyData->sum('visitors'),
            'page_views' => $dailyData->sum('page_views'),
            'unique_visitors' => $dailyData->sum('unique_visitors'),
            'bounce_rate' => $dailyData->avg('bounce_rate'),
            'session_duration' => $dailyData->avg('session_duration'),
            'abidjan_visitors' => $dailyData->sum('abidjan_visitors'),
            'interior_visitors' => $dailyData->sum('interior_visitors'),
            'international_visitors' => $dailyData->sum('international_visitors'),
            'products_viewed' => $dailyData->sum('products_viewed'),
            'searches_count' => $dailyData->sum('searches_count'),
            'organic_traffic' => $dailyData->sum('organic_traffic'),
        ];
        
        return self::updateOrCreate(
            [
                'date' => $endDate,
                'metric_type' => 'weekly'
            ],
            $weeklyData
        );
    }
}
