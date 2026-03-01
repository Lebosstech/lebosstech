<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Visitor;
use App\Models\Product;
use App\Models\SearchLog;
use App\Models\Alert;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AnalyticsController extends Controller
{
    /**
     * Dashboard principal
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '7days');
        $compare = $request->get('compare', true);
        
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        // KPIs principaux
        $kpis = Analytics::getKPIs($startDate, $endDate);
        
        // Comparaison avec période précédente
        $comparison = null;
        if ($compare) {
            $days = $startDate->diffInDays($endDate) + 1;
            $previousStart = $startDate->copy()->subDays($days);
            $previousEnd = $startDate->copy()->subDay();
            
            $comparison = Analytics::comparePeriods(
                $startDate, $endDate,
                $previousStart, $previousEnd
            );
        }
        
        // Données pour graphiques
        $chartData = [
            'revenue' => Analytics::getChartData('revenue', $startDate, $endDate),
            'visitors' => Analytics::getChartData('visitors', $startDate, $endDate),
            'orders' => Analytics::getChartData('orders_count', $startDate, $endDate),
            'conversion' => Analytics::getChartData('conversion_rate', $startDate, $endDate),
        ];
        
        // Top produits
        $topProducts = Analytics::getTopProducts($startDate, $endDate, 10);
        
        // Analyse géographique
        $geoAnalysis = Analytics::getGeographicAnalysis($startDate, $endDate);
        
        // Statistiques de recherche
        $searchStats = $this->getSearchStats($startDate, $endDate);
        
        // Alertes actives
        $activeAlerts = Alert::active()->count();
        $recentAlerts = Alert::where('last_triggered', '>=', now()->subDay())
            ->orderByDesc('last_triggered')
            ->limit(5)
            ->get();
        
        return view('admin.analytics.dashboard', compact(
            'kpis', 'comparison', 'chartData', 'topProducts', 
            'geoAnalysis', 'searchStats', 'activeAlerts', 'recentAlerts',
            'period', 'startDate', 'endDate'
        ));
    }

    /**
     * Analytics en temps réel
     */
    public function realTime()
    {
        $stats = [
            'visitors_online' => $this->getOnlineVisitors(),
            'todays_visitors' => Visitor::whereDate('created_at', today())->count(),
            'todays_page_views' => Visitor::whereDate('created_at', today())->sum('page_views'),
            'todays_whatsapp_clicks' => Visitor::whereDate('created_at', today())->sum('whatsapp_clicks'),
            'recent_visitors' => $this->getRecentVisitors(),
            'live_activity' => $this->getLiveActivity(),
            'top_pages' => $this->getTopPagesRealTime(),
            'traffic_sources' => $this->getTrafficSourcesRealTime(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Données pour graphiques
     */
    public function chartData(Request $request)
    {
        $metric = $request->get('metric', 'revenue');
        $period = $request->get('period', '7days');
        
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        $data = Analytics::getChartData($metric, $startDate, $endDate);
        
        return response()->json($data);
    }

    /**
     * Analyse géographique détaillée
     */
    public function geographic(Request $request)
    {
        $period = $request->get('period', '30days');
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        $data = [
            'overview' => Analytics::getGeographicAnalysis($startDate, $endDate),
            'detailed' => Visitor::getGeographicDistribution($startDate, $endDate),
            'map_data' => $this->getMapData($startDate, $endDate),
            'city_stats' => $this->getCityStats($startDate, $endDate),
        ];
        
        return view('admin.analytics.geographic', $data);
    }

    /**
     * Analytics des appareils
     */
    public function devices(Request $request)
    {
        $period = $request->get('period', '30days');
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        $data = [
            'device_stats' => Visitor::getDeviceStats($startDate, $endDate),
            'browser_stats' => $this->getBrowserStats($startDate, $endDate),
            'os_stats' => $this->getOSStats($startDate, $endDate),
            'screen_stats' => $this->getScreenStats($startDate, $endDate),
        ];
        
        return view('admin.analytics.devices', $data);
    }

    /**
     * Analytics SEO
     */
    public function seo(Request $request)
    {
        $period = $request->get('period', '30days');
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        $data = [
            'organic_traffic' => $this->getOrganicTraffic($startDate, $endDate),
            'keyword_positions' => $this->getKeywordPositions(),
            'search_console_data' => $this->getSearchConsoleData($startDate, $endDate),
            'backlinks_stats' => $this->getBacklinksStats(),
            'page_speed' => $this->getPageSpeedStats(),
        ];
        
        return view('admin.analytics.seo', $data);
    }

    /**
     * Export des données
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $period = $request->get('period', '30days');
        $type = $request->get('type', 'overview');
        
        [$startDate, $endDate] = $this->getPeriodDates($period);
        
        switch ($format) {
            case 'excel':
                return $this->exportExcel($type, $startDate, $endDate);
            case 'pdf':
                return $this->exportPDF($type, $startDate, $endDate);
            case 'csv':
                return $this->exportCSV($type, $startDate, $endDate);
            default:
                return redirect()->back()->with('error', 'Format non supporté');
        }
    }

    /**
     * Gestion des alertes
     */
    public function alerts()
    {
        $alerts = Alert::with('logs')->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.analytics.alerts', compact('alerts'));
    }

    /**
     * Créer une alerte
     */
    public function createAlert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:stock,traffic,sales,seo',
            'metric' => 'required|string',
            'condition' => 'required|in:less_than,greater_than,equals,less_than_or_equal,greater_than_or_equal',
            'threshold' => 'required|numeric',
            'frequency' => 'required|in:real_time,hourly,daily,weekly',
            'email_recipients' => 'required|array',
            'email_recipients.*' => 'email',
        ]);
        
        Alert::create($request->all());
        
        return redirect()->route('admin.analytics.alerts')
            ->with('success', 'Alerte créée avec succès');
    }

    /**
     * Rapport automatisé
     */
    public function scheduleReport(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'frequency' => 'required|in:daily,weekly,monthly',
            'recipients' => 'required|array',
            'recipients.*' => 'email',
            'sections' => 'required|array',
        ]);
        
        // Créer la tâche programmée (à implémenter avec Laravel Scheduler)
        
        return response()->json(['success' => true]);
    }

    /**
     * Méthodes privées
     */
    private function getPeriodDates($period)
    {
        switch ($period) {
            case 'today':
                return [now()->startOfDay(), now()->endOfDay()];
            case '7days':
                return [now()->subDays(6)->startOfDay(), now()->endOfDay()];
            case '30days':
                return [now()->subDays(29)->startOfDay(), now()->endOfDay()];
            case '90days':
                return [now()->subDays(89)->startOfDay(), now()->endOfDay()];
            case 'this_month':
                return [now()->startOfMonth(), now()->endOfMonth()];
            case 'last_month':
                return [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()];
            default:
                return [now()->subDays(6)->startOfDay(), now()->endOfDay()];
        }
    }

    private function getSearchStats($startDate, $endDate)
    {
        return [
            'total_searches' => SearchLog::whereBetween('created_at', [$startDate, $endDate])->count(),
            'unique_terms' => SearchLog::whereBetween('created_at', [$startDate, $endDate])
                ->distinct('query')->count(),
            'avg_results' => SearchLog::whereBetween('created_at', [$startDate, $endDate])
                ->avg('results_count'),
            'top_terms' => SearchLog::whereBetween('created_at', [$startDate, $endDate])
                ->select('query', DB::raw('COUNT(*) as count'))
                ->groupBy('query')
                ->orderByDesc('count')
                ->limit(10)
                ->get(),
            'no_results' => SearchLog::whereBetween('created_at', [$startDate, $endDate])
                ->where('results_count', 0)
                ->count(),
        ];
    }

    private function getOnlineVisitors()
    {
        return Visitor::where('last_activity', '>=', now()->subMinutes(5))->count();
    }

    private function getRecentVisitors()
    {
        return Visitor::orderByDesc('last_activity')
            ->limit(10)
            ->get()
            ->map(function ($visitor) {
                return [
                    'id' => $visitor->id,
                    'location' => $visitor->city . ', ' . $visitor->region,
                    'device' => $visitor->device_type,
                    'browser' => $visitor->browser,
                    'last_activity' => $visitor->last_activity->diffForHumans(),
                    'page_views' => $visitor->page_views,
                ];
            });
    }

    private function getLiveActivity()
    {
        return Visitor::where('last_activity', '>=', now()->subMinutes(10))
            ->orderByDesc('last_activity')
            ->limit(20)
            ->get(['session_id', 'region', 'device_type', 'last_activity', 'page_views']);
    }

    private function getTopPagesRealTime()
    {
        // Simulation - en production, tracker les pages vues
        return [
            ['page' => '/', 'views' => rand(50, 200)],
            ['page' => '/produits', 'views' => rand(30, 150)],
            ['page' => '/recherche', 'views' => rand(20, 100)],
            ['page' => '/contact', 'views' => rand(10, 50)],
        ];
    }

    private function getTrafficSourcesRealTime()
    {
        return Visitor::whereDate('created_at', today())
            ->selectRaw('
                CASE 
                    WHEN utm_source IS NOT NULL THEN utm_source
                    WHEN referrer LIKE "%google%" THEN "Google"
                    WHEN referrer LIKE "%facebook%" THEN "Facebook"
                    WHEN referrer IS NOT NULL THEN "Referral"
                    ELSE "Direct"
                END as source,
                COUNT(*) as visitors
            ')
            ->groupBy('source')
            ->orderByDesc('visitors')
            ->get();
    }

    private function getMapData($startDate, $endDate)
    {
        return Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('latitude', 'longitude', 'city', 'region', DB::raw('COUNT(*) as visitors'))
            ->groupBy(['latitude', 'longitude', 'city', 'region'])
            ->get();
    }

    private function getCityStats($startDate, $endDate)
    {
        return Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('city')
            ->select('city', 'region', DB::raw('COUNT(*) as visitors'), DB::raw('SUM(page_views) as page_views'))
            ->groupBy(['city', 'region'])
            ->orderByDesc('visitors')
            ->limit(20)
            ->get();
    }

    private function getBrowserStats($startDate, $endDate)
    {
        return Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->get();
    }

    private function getOSStats($startDate, $endDate)
    {
        return Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->select('os', DB::raw('COUNT(*) as count'))
            ->groupBy('os')
            ->orderByDesc('count')
            ->get();
    }

    private function getScreenStats($startDate, $endDate)
    {
        // Simulation - en production, tracker les résolutions d'écran
        return collect([
            ['resolution' => '1920x1080', 'count' => rand(100, 500)],
            ['resolution' => '1366x768', 'count' => rand(80, 300)],
            ['resolution' => '375x667', 'count' => rand(150, 400)],
            ['resolution' => '414x896', 'count' => rand(120, 350)],
        ]);
    }

    private function getOrganicTraffic($startDate, $endDate)
    {
        return Visitor::whereBetween('created_at', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('utm_source', 'google')
                      ->orWhere('referrer', 'like', '%google.%')
                      ->orWhere('referrer', 'like', '%bing.%')
                      ->orWhere('referrer', 'like', '%yahoo.%');
            })
            ->selectRaw('DATE(created_at) as date, COUNT(*) as visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getKeywordPositions()
    {
        // Simulation - en production, intégrer Google Search Console API
        return [
            ['keyword' => 'ordinateur abidjan', 'position' => 3, 'change' => '+2'],
            ['keyword' => 'téléphone côte d\'ivoire', 'position' => 7, 'change' => '-1'],
            ['keyword' => 'électronique abidjan', 'position' => 12, 'change' => '+5'],
            ['keyword' => 'leboss tech', 'position' => 1, 'change' => '0'],
        ];
    }

    private function getSearchConsoleData($startDate, $endDate)
    {
        // Simulation - en production, utiliser l'API Google Search Console
        return [
            'clicks' => rand(1000, 5000),
            'impressions' => rand(10000, 50000),
            'ctr' => rand(2, 8) . '%',
            'position' => rand(10, 30),
        ];
    }

    private function getBacklinksStats()
    {
        // Simulation - en production, utiliser des outils SEO comme Ahrefs, SEMrush
        return [
            'total_backlinks' => rand(50, 200),
            'referring_domains' => rand(20, 80),
            'domain_rating' => rand(15, 40),
            'new_backlinks' => rand(5, 20),
        ];
    }

    private function getPageSpeedStats()
    {
        // Simulation - en production, utiliser Google PageSpeed Insights API
        return [
            'mobile_score' => rand(70, 95),
            'desktop_score' => rand(80, 98),
            'lcp' => rand(1.5, 3.0),
            'fid' => rand(50, 150),
            'cls' => rand(0.05, 0.25),
        ];
    }

    private function exportExcel($type, $startDate, $endDate)
    {
        // À implémenter avec Laravel Excel
        return response()->json(['message' => 'Export Excel en cours de développement']);
    }

    private function exportPDF($type, $startDate, $endDate)
    {
        // À implémenter avec DomPDF ou Snappy
        return response()->json(['message' => 'Export PDF en cours de développement']);
    }

    private function exportCSV($type, $startDate, $endDate)
    {
        $filename = "analytics_{$type}_" . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function () use ($type, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'overview') {
                fputcsv($file, ['Date', 'Visiteurs', 'Pages vues', 'Revenus', 'Commandes', 'Clics WhatsApp']);
                
                $analytics = Analytics::whereBetween('date', [$startDate, $endDate])
                    ->where('metric_type', 'daily')
                    ->orderBy('date')
                    ->get();
                
                foreach ($analytics as $analytic) {
                    fputcsv($file, [
                        $analytic->date->format('d/m/Y'),
                        $analytic->visitors,
                        $analytic->page_views,
                        $analytic->revenue,
                        $analytic->orders_count,
                        $analytic->whatsapp_clicks,
                    ]);
                }
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
