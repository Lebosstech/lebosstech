<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Analytics;
use App\Models\Visitor;
use App\Models\Product;
use App\Models\SearchLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:generate {--date=} {--type=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les données analytics pour une date donnée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : now()->subDay();
        $type = $this->option('type');
        
        $this->info("Génération des analytics {$type} pour le {$date->format('d/m/Y')}...");
        
        switch ($type) {
            case 'daily':
                $this->generateDaily($date);
                break;
            case 'weekly':
                $this->generateWeekly($date);
                break;
            case 'monthly':
                $this->generateMonthly($date);
                break;
            default:
                $this->error('Type non supporté. Utilisez: daily, weekly, monthly');
                return 1;
        }
        
        $this->info('Analytics générées avec succès !');
        return 0;
    }

    /**
     * Génère les analytics journalières
     */
    private function generateDaily(Carbon $date)
    {
        $startDate = $date->copy()->startOfDay();
        $endDate = $date->copy()->endOfDay();
        
        // Statistiques des visiteurs
        $visitorStats = Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as visitors,
                COUNT(DISTINCT ip_address) as unique_visitors,
                SUM(page_views) as page_views,
                AVG(session_duration) as avg_session_duration,
                SUM(CASE WHEN is_bounce = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as bounce_rate,
                SUM(whatsapp_clicks) as whatsapp_clicks,
                SUM(CASE WHEN converted = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as conversion_rate
            ')
            ->first();
        
        // Répartition géographique
        $geoStats = Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                SUM(CASE WHEN region = "Abidjan" THEN 1 ELSE 0 END) as abidjan_visitors,
                SUM(CASE WHEN region != "Abidjan" AND country = "Côte d\'Ivoire" THEN 1 ELSE 0 END) as interior_visitors,
                SUM(CASE WHEN country != "Côte d\'Ivoire" THEN 1 ELSE 0 END) as international_visitors
            ')
            ->first();
        
        // Statistiques de recherche
        $searchStats = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('COUNT(*) as searches_count')
            ->first();
        
        // Top produits (simulation - en production, tracker les vues produits)
        $topProducts = Product::take(10)->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'views' => rand(10, 100),
                'clicks' => rand(5, 50)
            ];
        })->toArray();
        
        // Top catégories
        $topCategories = DB::table('categories')
            ->select('categories.name', DB::raw('COUNT(products.id) as product_count'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('product_count')
            ->take(5)
            ->get()
            ->toArray();
        
        // Top termes de recherche
        $topSearchTerms = SearchLog::whereBetween('created_at', [$startDate, $endDate])
            ->select('query as search_term', DB::raw('COUNT(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->take(10)
            ->get()
            ->toArray();
        
        // Trafic organique (simulation)
        $organicTraffic = Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('utm_source', 'google')
                      ->orWhere('referrer', 'like', '%google.%');
            })
            ->count();
        
        // Données de vente (simulation - en production, intégrer avec système de commandes)
        $revenue = rand(10000, 100000);
        $orders = rand(5, 50);
        $avgOrderValue = $orders > 0 ? $revenue / $orders : 0;
        
        // Enregistrement des analytics
        Analytics::recordDaily([
            'revenue' => $revenue,
            'orders_count' => $orders,
            'whatsapp_clicks' => $visitorStats->whatsapp_clicks ?? 0,
            'average_order_value' => $avgOrderValue,
            'conversion_rate' => $visitorStats->conversion_rate ?? 0,
            'visitors' => $visitorStats->visitors ?? 0,
            'page_views' => $visitorStats->page_views ?? 0,
            'unique_visitors' => $visitorStats->unique_visitors ?? 0,
            'bounce_rate' => $visitorStats->bounce_rate ?? 0,
            'session_duration' => $visitorStats->avg_session_duration ?? 0,
            'abidjan_visitors' => $geoStats->abidjan_visitors ?? 0,
            'interior_visitors' => $geoStats->interior_visitors ?? 0,
            'international_visitors' => $geoStats->international_visitors ?? 0,
            'products_viewed' => array_sum(array_column($topProducts, 'views')),
            'searches_count' => $searchStats->searches_count ?? 0,
            'top_products' => $topProducts,
            'top_categories' => $topCategories,
            'top_search_terms' => $topSearchTerms,
            'organic_traffic' => $organicTraffic,
            'avg_position' => rand(10, 30) + (rand(0, 99) / 100), // Simulation
            'indexed_pages' => rand(50, 200),
            'keyword_positions' => [
                ['keyword' => 'ordinateur abidjan', 'position' => rand(1, 10)],
                ['keyword' => 'téléphone côte d\'ivoire', 'position' => rand(5, 15)],
                ['keyword' => 'électronique abidjan', 'position' => rand(8, 20)],
            ]
        ], $date->toDateString());
        
        $this->line("✓ Analytics journalières générées pour le {$date->format('d/m/Y')}");
    }

    /**
     * Génère les analytics hebdomadaires
     */
    private function generateWeekly(Carbon $date)
    {
        $startDate = $date->copy()->startOfWeek();
        $endDate = $date->copy()->endOfWeek();
        
        Analytics::generateWeekly($startDate->toDateString(), $endDate->toDateString());
        
        $this->line("✓ Analytics hebdomadaires générées pour la semaine du {$startDate->format('d/m/Y')}");
    }

    /**
     * Génère les analytics mensuelles
     */
    private function generateMonthly(Carbon $date)
    {
        $startDate = $date->copy()->startOfMonth();
        $endDate = $date->copy()->endOfMonth();
        
        $dailyData = Analytics::where('metric_type', 'daily')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
        
        if ($dailyData->isEmpty()) {
            $this->warn('Aucune donnée journalière trouvée pour ce mois');
            return;
        }
        
        $monthlyData = [
            'date' => $endDate->toDateString(),
            'metric_type' => 'monthly',
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
        
        Analytics::updateOrCreate(
            [
                'date' => $endDate->toDateString(),
                'metric_type' => 'monthly'
            ],
            $monthlyData
        );
        
        $this->line("✓ Analytics mensuelles générées pour {$date->format('F Y')}");
    }
}
