<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Analytics;
use App\Models\Visitor;
use App\Models\Alert;
use Carbon\Carbon;

class AnalyticsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $this->command->info('Génération des données analytics de test...');
        
        // Génération des analytics pour les 30 derniers jours
        $this->generateAnalytics();
        
        // Génération des visiteurs de test
        $this->generateVisitors();
        
        // Création des alertes par défaut
        $this->createDefaultAlerts();
        
        $this->command->info('Données analytics générées avec succès !');
    }

    /**
     * Génère les données analytics
     */
    private function generateAnalytics()
    {
        $startDate = now()->subDays(30);
        
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            // Simulation de données réalistes avec tendances
            $baseVisitors = 150 + rand(-50, 100);
            $weekendMultiplier = $date->isWeekend() ? 0.7 : 1.0;
            $trendMultiplier = 1 + ($i * 0.02); // Croissance de 2% par jour
            
            $visitors = (int)($baseVisitors * $weekendMultiplier * $trendMultiplier);
            $pageViews = $visitors * rand(2, 5);
            $uniqueVisitors = (int)($visitors * 0.8);
            $whatsappClicks = (int)($visitors * rand(5, 15) / 100);
            $revenue = $whatsappClicks * rand(15000, 50000);
            $orders = (int)($whatsappClicks * rand(60, 90) / 100);
            
            Analytics::create([
                'date' => $date->toDateString(),
                'metric_type' => 'daily',
                'revenue' => $revenue,
                'orders_count' => $orders,
                'whatsapp_clicks' => $whatsappClicks,
                'average_order_value' => $orders > 0 ? $revenue / $orders : 0,
                'conversion_rate' => $visitors > 0 ? ($whatsappClicks / $visitors) * 100 : 0,
                'visitors' => $visitors,
                'page_views' => $pageViews,
                'unique_visitors' => $uniqueVisitors,
                'bounce_rate' => rand(35, 65),
                'session_duration' => rand(120, 300),
                'abidjan_visitors' => (int)($visitors * 0.7),
                'interior_visitors' => (int)($visitors * 0.25),
                'international_visitors' => (int)($visitors * 0.05),
                'products_viewed' => rand(500, 2000),
                'searches_count' => rand(50, 200),
                'top_products' => $this->generateTopProducts(),
                'top_categories' => $this->generateTopCategories(),
                'top_search_terms' => $this->generateTopSearchTerms(),
                'organic_traffic' => (int)($visitors * rand(40, 60) / 100),
                'avg_position' => rand(8, 25) + (rand(0, 99) / 100),
                'indexed_pages' => rand(80, 150),
                'keyword_positions' => $this->generateKeywordPositions(),
            ]);
        }
    }

    /**
     * Génère les visiteurs de test
     */
    private function generateVisitors()
    {
        $regions = ['Abidjan', 'Bouaké', 'Daloa', 'San-Pédro', 'Yamoussoukro'];
        $devices = ['mobile', 'desktop', 'tablet'];
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge'];
        $os = ['Windows', 'Android', 'iOS', 'macOS', 'Linux'];
        
        for ($i = 0; $i < 200; $i++) {
            $createdAt = now()->subDays(rand(0, 30));
            $sessionDuration = rand(30, 1800);
            $pageViews = rand(1, 10);
            $isAbidjan = rand(1, 100) <= 70; // 70% Abidjan
            
            Visitor::create([
                'session_id' => 'sess_' . uniqid(),
                'ip_address' => $this->generateRandomIP(),
                'user_agent' => $this->generateUserAgent(),
                'device_type' => $devices[array_rand($devices)],
                'browser' => $browsers[array_rand($browsers)],
                'os' => $os[array_rand($os)],
                'country' => rand(1, 100) <= 95 ? 'Côte d\'Ivoire' : 'France',
                'region' => $isAbidjan ? 'Abidjan' : $regions[array_rand($regions)],
                'city' => $isAbidjan ? 'Abidjan' : $regions[array_rand($regions)],
                'latitude' => $isAbidjan ? 5.3599 : rand(4, 10) + (rand(0, 9999) / 10000),
                'longitude' => $isAbidjan ? -4.0083 : rand(-8, -3) + (rand(0, 9999) / 10000),
                'first_visit' => $createdAt,
                'last_activity' => $createdAt->copy()->addSeconds($sessionDuration),
                'page_views' => $pageViews,
                'session_duration' => $sessionDuration,
                'is_bounce' => $pageViews == 1,
                'referrer' => $this->generateReferrer(),
                'utm_source' => rand(1, 100) <= 30 ? ['google', 'facebook', 'instagram'][array_rand(['google', 'facebook', 'instagram'])] : null,
                'utm_medium' => rand(1, 100) <= 30 ? ['cpc', 'social', 'organic'][array_rand(['cpc', 'social', 'organic'])] : null,
                'landing_page' => '/',
                'whatsapp_clicks' => rand(0, 3),
                'product_views' => rand(0, 5),
                'searches' => rand(0, 3),
                'converted' => rand(1, 100) <= 15, // 15% de conversion
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }

    /**
     * Crée les alertes par défaut
     */
    private function createDefaultAlerts()
    {
        $alerts = [
            [
                'name' => 'Stock Faible',
                'type' => 'stock',
                'metric' => 'low_stock_products',
                'condition' => 'greater_than',
                'threshold' => 0,
                'frequency' => 'daily',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '⚠️ {current_value} produit(s) ont un stock faible (≤5 unités)',
                'cooldown_minutes' => 60,
            ],
            [
                'name' => 'Rupture de Stock',
                'type' => 'stock',
                'metric' => 'out_of_stock_products',
                'condition' => 'greater_than',
                'threshold' => 0,
                'frequency' => 'real_time',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '🚨 {current_value} produit(s) en rupture de stock',
                'cooldown_minutes' => 30,
            ],
            [
                'name' => 'Pic de Trafic',
                'type' => 'traffic',
                'metric' => 'hourly_visitors',
                'condition' => 'greater_than',
                'threshold' => 100,
                'frequency' => 'hourly',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '📈 Pic de trafic détecté: {current_value} visiteurs cette heure',
                'cooldown_minutes' => 60,
            ],
            [
                'name' => 'Taux de Rebond Élevé',
                'type' => 'traffic',
                'metric' => 'bounce_rate',
                'condition' => 'greater_than',
                'threshold' => 70,
                'frequency' => 'daily',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '⚠️ Taux de rebond élevé: {current_value}%',
                'cooldown_minutes' => 1440, // 24h
            ],
            [
                'name' => 'Objectif Ventes Journalier',
                'type' => 'sales',
                'metric' => 'daily_revenue',
                'condition' => 'greater_than',
                'threshold' => 100000,
                'frequency' => 'daily',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '🎉 Objectif journalier atteint: {current_value} FCFA',
                'cooldown_minutes' => 1440, // 24h
            ],
            [
                'name' => 'Baisse de Trafic',
                'type' => 'traffic',
                'metric' => 'daily_visitors',
                'condition' => 'less_than',
                'threshold' => 50,
                'frequency' => 'daily',
                'email_enabled' => true,
                'email_recipients' => ['admin@lebosstech.com'],
                'message_template' => '📉 Trafic faible détecté: seulement {current_value} visiteurs aujourd\'hui',
                'cooldown_minutes' => 1440, // 24h
            ],
        ];

        foreach ($alerts as $alertData) {
            Alert::create($alertData);
        }
    }

    /**
     * Méthodes utilitaires
     */
    private function generateTopProducts()
    {
        return [
            ['id' => 1, 'name' => 'iPhone 15 Pro', 'views' => rand(50, 200), 'clicks' => rand(10, 50)],
            ['id' => 2, 'name' => 'MacBook Air M2', 'views' => rand(40, 150), 'clicks' => rand(8, 40)],
            ['id' => 3, 'name' => 'Samsung Galaxy S24', 'views' => rand(30, 120), 'clicks' => rand(6, 30)],
            ['id' => 4, 'name' => 'AirPods Pro', 'views' => rand(25, 100), 'clicks' => rand(5, 25)],
            ['id' => 5, 'name' => 'iPad Pro', 'views' => rand(20, 80), 'clicks' => rand(4, 20)],
        ];
    }

    private function generateTopCategories()
    {
        return [
            ['name' => 'Smartphones', 'product_count' => rand(20, 50)],
            ['name' => 'Ordinateurs', 'product_count' => rand(15, 40)],
            ['name' => 'Accessoires', 'product_count' => rand(10, 30)],
            ['name' => 'Tablettes', 'product_count' => rand(8, 25)],
            ['name' => 'Audio', 'product_count' => rand(5, 20)],
        ];
    }

    private function generateTopSearchTerms()
    {
        $terms = [
            'iphone', 'samsung', 'macbook', 'ordinateur', 'téléphone',
            'laptop', 'smartphone', 'apple', 'huawei', 'dell'
        ];
        
        return collect($terms)->map(function ($term) {
            return ['search_term' => $term, 'count' => rand(10, 100)];
        })->toArray();
    }

    private function generateKeywordPositions()
    {
        return [
            ['keyword' => 'ordinateur abidjan', 'position' => rand(3, 8)],
            ['keyword' => 'téléphone côte d\'ivoire', 'position' => rand(5, 12)],
            ['keyword' => 'électronique abidjan', 'position' => rand(8, 20)],
            ['keyword' => 'leboss tech', 'position' => rand(1, 3)],
            ['keyword' => 'smartphone abidjan', 'position' => rand(4, 10)],
        ];
    }

    private function generateRandomIP()
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }

    private function generateUserAgent()
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Android 14; Mobile; rv:109.0) Gecko/111.0 Firefox/115.0',
        ];
        
        return $userAgents[array_rand($userAgents)];
    }

    private function generateReferrer()
    {
        $referrers = [
            null,
            'https://www.google.com/',
            'https://www.facebook.com/',
            'https://www.instagram.com/',
            'https://www.youtube.com/',
            'https://lebosstech.ci/',
        ];
        
        return $referrers[array_rand($referrers)];
    }
}
