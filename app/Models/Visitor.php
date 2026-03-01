<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'first_visit',
        'last_activity',
        'page_views',
        'session_duration',
        'is_bounce',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'landing_page',
        'whatsapp_clicks',
        'product_views',
        'searches',
        'converted',
    ];

    protected $casts = [
        'first_visit' => 'datetime',
        'last_activity' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_bounce' => 'boolean',
        'converted' => 'boolean',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Crée ou met à jour un visiteur
     */
    public static function trackVisitor($request, $additionalData = [])
    {
        $sessionId = session()->getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        
        // Détection du device
        $deviceInfo = self::parseUserAgent($userAgent);
        
        // Géolocalisation (simulation - en production utiliser un service comme MaxMind)
        $geoData = self::getGeoData($ipAddress);
        
        $visitor = self::updateOrCreate(
            ['session_id' => $sessionId],
            array_merge([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'device_type' => $deviceInfo['device'],
                'browser' => $deviceInfo['browser'],
                'os' => $deviceInfo['os'],
                'country' => $geoData['country'],
                'region' => $geoData['region'],
                'city' => $geoData['city'],
                'latitude' => $geoData['latitude'],
                'longitude' => $geoData['longitude'],
                'first_visit' => now(),
                'last_activity' => now(),
                'referrer' => $request->header('referer'),
                'utm_source' => $request->get('utm_source'),
                'utm_medium' => $request->get('utm_medium'),
                'utm_campaign' => $request->get('utm_campaign'),
                'landing_page' => $request->url(),
            ], $additionalData)
        );
        
        // Si c'est une mise à jour, on incrémente les page views
        if (!$visitor->wasRecentlyCreated) {
            $visitor->increment('page_views');
            $visitor->update([
                'last_activity' => now(),
                'session_duration' => now()->diffInSeconds($visitor->first_visit),
                'is_bounce' => $visitor->page_views <= 1
            ]);
        }
        
        return $visitor;
    }

    /**
     * Parse User Agent pour extraire device, browser, OS
     */
    private static function parseUserAgent($userAgent)
    {
        $device = 'desktop';
        $browser = 'unknown';
        $os = 'unknown';
        
        // Détection mobile/tablet
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            $device = preg_match('/iPad/', $userAgent) ? 'tablet' : 'mobile';
        }
        
        // Détection browser
        if (preg_match('/Chrome/', $userAgent)) $browser = 'Chrome';
        elseif (preg_match('/Firefox/', $userAgent)) $browser = 'Firefox';
        elseif (preg_match('/Safari/', $userAgent)) $browser = 'Safari';
        elseif (preg_match('/Edge/', $userAgent)) $browser = 'Edge';
        
        // Détection OS
        if (preg_match('/Windows/', $userAgent)) $os = 'Windows';
        elseif (preg_match('/Mac/', $userAgent)) $os = 'macOS';
        elseif (preg_match('/Linux/', $userAgent)) $os = 'Linux';
        elseif (preg_match('/Android/', $userAgent)) $os = 'Android';
        elseif (preg_match('/iOS/', $userAgent)) $os = 'iOS';
        
        return compact('device', 'browser', 'os');
    }

    /**
     * Obtient les données géographiques (simulation)
     */
    private static function getGeoData($ipAddress)
    {
        // En production, utiliser un service comme MaxMind GeoIP2
        // Pour la démo, on simule des données pour la Côte d'Ivoire
        
        $regions = [
            'Abidjan' => ['lat' => 5.3599, 'lng' => -4.0083],
            'Bouaké' => ['lat' => 7.6939, 'lng' => -5.0300],
            'Daloa' => ['lat' => 6.8775, 'lng' => -6.4503],
            'San-Pédro' => ['lat' => 4.7467, 'lng' => -6.6364],
            'Yamoussoukro' => ['lat' => 6.8276, 'lng' => -5.2893],
        ];
        
        // Simulation : 70% Abidjan, 25% intérieur, 5% international
        $rand = rand(1, 100);
        
        if ($rand <= 70) {
            $region = 'Abidjan';
            $coords = $regions['Abidjan'];
            return [
                'country' => 'Côte d\'Ivoire',
                'region' => $region,
                'city' => 'Abidjan',
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng']
            ];
        } elseif ($rand <= 95) {
            $interiorRegions = array_slice($regions, 1, null, true);
            $region = array_rand($interiorRegions);
            $coords = $interiorRegions[$region];
            return [
                'country' => 'Côte d\'Ivoire',
                'region' => $region,
                'city' => $region,
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng']
            ];
        } else {
            // International
            $countries = [
                'France' => ['lat' => 46.2276, 'lng' => 2.2137],
                'Burkina Faso' => ['lat' => 12.2383, 'lng' => -1.5616],
                'Mali' => ['lat' => 17.5707, 'lng' => -3.9962],
            ];
            $country = array_rand($countries);
            $coords = $countries[$country];
            return [
                'country' => $country,
                'region' => null,
                'city' => null,
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng']
            ];
        }
    }

    /**
     * Enregistre un clic WhatsApp
     */
    public function recordWhatsAppClick()
    {
        $this->increment('whatsapp_clicks');
        $this->update(['converted' => true]);
    }

    /**
     * Enregistre une vue produit
     */
    public function recordProductView()
    {
        $this->increment('product_views');
    }

    /**
     * Enregistre une recherche
     */
    public function recordSearch()
    {
        $this->increment('searches');
    }

    /**
     * Statistiques des visiteurs par période
     */
    public static function getStats($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                COUNT(*) as total_visitors,
                COUNT(DISTINCT ip_address) as unique_visitors,
                SUM(page_views) as total_page_views,
                AVG(page_views) as avg_pages_per_session,
                AVG(session_duration) as avg_session_duration,
                SUM(CASE WHEN is_bounce = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as bounce_rate,
                SUM(whatsapp_clicks) as total_whatsapp_clicks,
                SUM(CASE WHEN converted = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as conversion_rate
            ')
            ->first();
    }

    /**
     * Répartition géographique
     */
    public static function getGeographicDistribution($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                region,
                country,
                COUNT(*) as visitors_count,
                SUM(page_views) as page_views,
                SUM(whatsapp_clicks) as whatsapp_clicks
            ')
            ->groupBy(['region', 'country'])
            ->orderByDesc('visitors_count')
            ->get();
    }

    /**
     * Répartition par device
     */
    public static function getDeviceStats($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                device_type,
                browser,
                os,
                COUNT(*) as count,
                AVG(session_duration) as avg_duration,
                SUM(whatsapp_clicks) as whatsapp_clicks
            ')
            ->groupBy(['device_type', 'browser', 'os'])
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Sources de trafic
     */
    public static function getTrafficSources($startDate, $endDate)
    {
        return self::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('
                CASE 
                    WHEN utm_source IS NOT NULL THEN CONCAT(utm_source, " / ", COALESCE(utm_medium, "unknown"))
                    WHEN referrer IS NOT NULL THEN "Referral"
                    ELSE "Direct"
                END as source,
                COUNT(*) as visitors,
                SUM(page_views) as page_views,
                SUM(whatsapp_clicks) as conversions
            ')
            ->groupBy('source')
            ->orderByDesc('visitors')
            ->get();
    }
}
