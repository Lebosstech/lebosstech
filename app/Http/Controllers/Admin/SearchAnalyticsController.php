<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchLog;
use App\Models\PopularSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SearchAnalyticsController extends Controller
{
    /**
     * Tableau de bord des analytics de recherche
     */
    public function index(Request $request)
    {
        $period = $request->get('period', '30'); // 7, 30, 90 jours
        $startDate = Carbon::now()->subDays($period);
        
        // Statistiques générales
        $totalSearches = SearchLog::where('created_at', '>=', $startDate)->count();
        $uniqueQueries = SearchLog::where('created_at', '>=', $startDate)
            ->distinct('query')->count('query');
        $avgResultsPerSearch = SearchLog::where('created_at', '>=', $startDate)
            ->avg('results_count');
        $zeroResultsSearches = SearchLog::where('created_at', '>=', $startDate)
            ->where('results_count', 0)->count();
        
        // Recherches les plus populaires
        $popularQueries = SearchLog::where('created_at', '>=', $startDate)
            ->select('query')
            ->selectRaw('COUNT(*) as search_count')
            ->selectRaw('AVG(results_count) as avg_results')
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit(20)
            ->get();
        
        // Recherches sans résultats
        $zeroResultQueries = SearchLog::where('created_at', '>=', $startDate)
            ->where('results_count', 0)
            ->select('query')
            ->selectRaw('COUNT(*) as search_count')
            ->groupBy('query')
            ->orderByDesc('search_count')
            ->limit(10)
            ->get();
        
        // Évolution des recherches par jour
        $searchesByDay = SearchLog::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        // Filtres les plus utilisés
        $filterUsage = SearchLog::where('created_at', '>=', $startDate)
            ->whereNotNull('filters')
            ->where('filters', '!=', '[]')
            ->get()
            ->flatMap(function ($log) {
                $filters = is_string($log->filters) ? json_decode($log->filters, true) : $log->filters;
                return collect($filters)->map(function ($value, $key) {
                    return ['filter' => $key, 'value' => $value];
                });
            })
            ->groupBy('filter')
            ->map(function ($group, $filter) {
                return [
                    'filter' => $filter,
                    'count' => $group->count(),
                    'values' => $group->groupBy('value')->map->count()->sortDesc()->take(5)
                ];
            })
            ->sortByDesc('count')
            ->take(5);
        
        // Appareils les plus utilisés
        $deviceStats = SearchLog::where('created_at', '>=', $startDate)
            ->selectRaw('
                CASE 
                    WHEN user_agent LIKE "%Mobile%" THEN "Mobile"
                    WHEN user_agent LIKE "%Tablet%" THEN "Tablette"
                    ELSE "Desktop"
                END as device_type
            ')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
        
        // Heures de pointe
        $searchesByHour = SearchLog::where('created_at', '>=', $startDate)
            ->selectRaw('HOUR(created_at) as hour')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour')
            ->toArray();
        
        return view('admin.search-analytics.index', compact(
            'totalSearches',
            'uniqueQueries',
            'avgResultsPerSearch',
            'zeroResultsSearches',
            'popularQueries',
            'zeroResultQueries',
            'searchesByDay',
            'filterUsage',
            'deviceStats',
            'searchesByHour',
            'period'
        ));
    }
    
    /**
     * Détails d'une recherche spécifique
     */
    public function searchDetails(Request $request)
    {
        $query = $request->get('query');
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);
        
        $searchLogs = SearchLog::where('query', $query)
            ->where('created_at', '>=', $startDate)
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(50);
        
        $stats = [
            'total_searches' => $searchLogs->total(),
            'avg_results' => SearchLog::where('query', $query)
                ->where('created_at', '>=', $startDate)
                ->avg('results_count'),
            'zero_results_count' => SearchLog::where('query', $query)
                ->where('created_at', '>=', $startDate)
                ->where('results_count', 0)
                ->count(),
            'unique_users' => SearchLog::where('query', $query)
                ->where('created_at', '>=', $startDate)
                ->distinct('user_id')
                ->count('user_id'),
        ];
        
        return view('admin.search-analytics.details', compact(
            'query',
            'searchLogs',
            'stats',
            'period'
        ));
    }
    
    /**
     * Export des données de recherche
     */
    public function export(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);
        
        $searches = SearchLog::where('created_at', '>=', $startDate)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
        
        $filename = 'search_analytics_' . $period . 'days_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($searches) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Date',
                'Requête',
                'Résultats',
                'Filtres',
                'Tri',
                'Utilisateur',
                'IP',
                'Appareil'
            ]);
            
            foreach ($searches as $search) {
                fputcsv($file, [
                    $search->created_at->format('Y-m-d H:i:s'),
                    $search->query,
                    $search->results_count,
                    json_encode($search->filters),
                    $search->sort_by,
                    $search->user ? $search->user->name : 'Anonyme',
                    $search->ip_address,
                    $this->detectDevice($search->user_agent)
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Gestion des recherches populaires
     */
    public function popularSearches()
    {
        $popularSearches = PopularSearch::orderByDesc('search_count')
            ->orderByDesc('last_searched_at')
            ->paginate(50);
        
        return view('admin.search-analytics.popular', compact('popularSearches'));
    }
    
    /**
     * Supprimer une recherche populaire
     */
    public function deletePopularSearch(PopularSearch $popularSearch)
    {
        $popularSearch->delete();
        
        return redirect()->back()->with('success', 'Recherche populaire supprimée avec succès.');
    }
    
    /**
     * API pour les graphiques
     */
    public function apiStats(Request $request)
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);
        
        $data = [
            'searches_by_day' => SearchLog::where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            
            'top_queries' => SearchLog::where('created_at', '>=', $startDate)
                ->select('query')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('query')
                ->orderByDesc('count')
                ->limit(10)
                ->get(),
            
            'device_stats' => SearchLog::where('created_at', '>=', $startDate)
                ->selectRaw('
                    CASE 
                        WHEN user_agent LIKE "%Mobile%" THEN "Mobile"
                        WHEN user_agent LIKE "%Tablet%" THEN "Tablette"
                        ELSE "Desktop"
                    END as device
                ')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('device')
                ->get(),
        ];
        
        return response()->json($data);
    }
    
    /**
     * Détecte le type d'appareil à partir du user agent
     */
    private function detectDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile') !== false) {
            return 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            return 'Tablette';
        } else {
            return 'Desktop';
        }
    }
}
