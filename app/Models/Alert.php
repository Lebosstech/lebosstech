<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'metric',
        'condition',
        'threshold',
        'frequency',
        'email_enabled',
        'email_recipients',
        'sms_enabled',
        'sms_recipients',
        'is_active',
        'last_triggered',
        'trigger_count',
        'conditions',
        'message_template',
        'cooldown_minutes',
    ];

    protected $casts = [
        'threshold' => 'decimal:2',
        'email_enabled' => 'boolean',
        'email_recipients' => 'array',
        'sms_enabled' => 'boolean',
        'sms_recipients' => 'array',
        'is_active' => 'boolean',
        'last_triggered' => 'datetime',
        'conditions' => 'array',
    ];

    /**
     * Vérifie toutes les alertes actives
     */
    public static function checkAllAlerts()
    {
        $alerts = self::where('is_active', true)->get();
        
        foreach ($alerts as $alert) {
            $alert->checkCondition();
        }
    }

    /**
     * Vérifie la condition de l'alerte
     */
    public function checkCondition()
    {
        // Vérifier le cooldown
        if ($this->last_triggered && 
            $this->last_triggered->addMinutes($this->cooldown_minutes)->isFuture()) {
            return false;
        }

        $currentValue = $this->getCurrentValue();
        $shouldTrigger = $this->evaluateCondition($currentValue);

        if ($shouldTrigger) {
            $this->trigger($currentValue);
        }

        return $shouldTrigger;
    }

    /**
     * Obtient la valeur actuelle de la métrique
     */
    private function getCurrentValue()
    {
        switch ($this->type) {
            case 'stock':
                return $this->getStockValue();
            case 'traffic':
                return $this->getTrafficValue();
            case 'sales':
                return $this->getSalesValue();
            case 'seo':
                return $this->getSeoValue();
            default:
                return 0;
        }
    }

    /**
     * Valeurs de stock
     */
    private function getStockValue()
    {
        switch ($this->metric) {
            case 'low_stock_products':
                return Product::where('stock', '<=', 5)->count();
            case 'out_of_stock_products':
                return Product::where('stock', 0)->count();
            case 'total_stock_value':
                return Product::sum(\DB::raw('stock * price'));
            default:
                return 0;
        }
    }

    /**
     * Valeurs de trafic
     */
    private function getTrafficValue()
    {
        $today = now()->toDateString();
        
        switch ($this->metric) {
            case 'daily_visitors':
                return Visitor::whereDate('created_at', $today)->count();
            case 'hourly_visitors':
                return Visitor::where('created_at', '>=', now()->subHour())->count();
            case 'bounce_rate':
                $stats = Visitor::whereDate('created_at', $today)
                    ->selectRaw('SUM(CASE WHEN is_bounce = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as bounce_rate')
                    ->first();
                return $stats->bounce_rate ?? 0;
            case 'page_views':
                return Visitor::whereDate('created_at', $today)->sum('page_views');
            default:
                return 0;
        }
    }

    /**
     * Valeurs de vente
     */
    private function getSalesValue()
    {
        $today = now()->toDateString();
        
        switch ($this->metric) {
            case 'daily_revenue':
                $analytics = Analytics::where('date', $today)
                    ->where('metric_type', 'daily')
                    ->first();
                return $analytics->revenue ?? 0;
            case 'daily_orders':
                $analytics = Analytics::where('date', $today)
                    ->where('metric_type', 'daily')
                    ->first();
                return $analytics->orders_count ?? 0;
            case 'whatsapp_clicks':
                return Visitor::whereDate('created_at', $today)->sum('whatsapp_clicks');
            case 'conversion_rate':
                $stats = Visitor::whereDate('created_at', $today)
                    ->selectRaw('SUM(CASE WHEN converted = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as conversion_rate')
                    ->first();
                return $stats->conversion_rate ?? 0;
            default:
                return 0;
        }
    }

    /**
     * Valeurs SEO
     */
    private function getSeoValue()
    {
        switch ($this->metric) {
            case 'organic_traffic':
                return Visitor::whereDate('created_at', now()->toDateString())
                    ->where('utm_source', 'google')
                    ->orWhere('referrer', 'like', '%google.%')
                    ->count();
            case 'avg_position':
                $analytics = Analytics::where('date', now()->toDateString())
                    ->where('metric_type', 'daily')
                    ->first();
                return $analytics->avg_position ?? 0;
            default:
                return 0;
        }
    }

    /**
     * Évalue la condition
     */
    private function evaluateCondition($currentValue)
    {
        switch ($this->condition) {
            case 'less_than':
                return $currentValue < $this->threshold;
            case 'greater_than':
                return $currentValue > $this->threshold;
            case 'equals':
                return $currentValue == $this->threshold;
            case 'less_than_or_equal':
                return $currentValue <= $this->threshold;
            case 'greater_than_or_equal':
                return $currentValue >= $this->threshold;
            default:
                return false;
        }
    }

    /**
     * Déclenche l'alerte
     */
    private function trigger($currentValue)
    {
        $this->update([
            'last_triggered' => now(),
            'trigger_count' => $this->trigger_count + 1
        ]);

        $message = $this->generateMessage($currentValue);

        // Envoi email
        if ($this->email_enabled && $this->email_recipients) {
            $this->sendEmailAlert($message, $currentValue);
        }

        // Envoi SMS (à implémenter avec un service SMS)
        if ($this->sms_enabled && $this->sms_recipients) {
            $this->sendSmsAlert($message, $currentValue);
        }

        // Log de l'alerte
        \Log::info("Alerte déclenchée: {$this->name}", [
            'type' => $this->type,
            'metric' => $this->metric,
            'current_value' => $currentValue,
            'threshold' => $this->threshold,
            'condition' => $this->condition
        ]);
    }

    /**
     * Génère le message d'alerte
     */
    private function generateMessage($currentValue)
    {
        if ($this->message_template) {
            return str_replace([
                '{name}',
                '{current_value}',
                '{threshold}',
                '{condition}',
                '{metric}',
                '{date}'
            ], [
                $this->name,
                $currentValue,
                $this->threshold,
                $this->condition,
                $this->metric,
                now()->format('d/m/Y H:i')
            ], $this->message_template);
        }

        return "Alerte {$this->name}: {$this->metric} = {$currentValue} ({$this->condition} {$this->threshold})";
    }

    /**
     * Envoie l'alerte par email
     */
    private function sendEmailAlert($message, $currentValue)
    {
        try {
            foreach ($this->email_recipients as $email) {
                Mail::raw($message, function ($mail) use ($email) {
                    $mail->to($email)
                         ->subject("🚨 Alerte LEBOSS TECH - {$this->name}");
                });
            }
        } catch (\Exception $e) {
            \Log::error("Erreur envoi email alerte: " . $e->getMessage());
        }
    }

    /**
     * Envoie l'alerte par SMS
     */
    private function sendSmsAlert($message, $currentValue)
    {
        // À implémenter avec un service SMS comme Twilio, Nexmo, etc.
        \Log::info("SMS Alert (non implémenté): {$message}");
    }

    /**
     * Alertes prédéfinies
     */
    public static function createDefaultAlerts()
    {
        $defaults = [
            [
                'name' => 'Stock Faible',
                'type' => 'stock',
                'metric' => 'low_stock_products',
                'condition' => 'greater_than',
                'threshold' => 0,
                'frequency' => 'daily',
                'message_template' => '⚠️ {current_value} produit(s) ont un stock faible (≤5 unités)',
                'email_recipients' => ['admin@lebosstech.com']
            ],
            [
                'name' => 'Rupture de Stock',
                'type' => 'stock',
                'metric' => 'out_of_stock_products',
                'condition' => 'greater_than',
                'threshold' => 0,
                'frequency' => 'real_time',
                'message_template' => '🚨 {current_value} produit(s) en rupture de stock',
                'email_recipients' => ['admin@lebosstech.com']
            ],
            [
                'name' => 'Pic de Trafic',
                'type' => 'traffic',
                'metric' => 'hourly_visitors',
                'condition' => 'greater_than',
                'threshold' => 100,
                'frequency' => 'hourly',
                'message_template' => '📈 Pic de trafic détecté: {current_value} visiteurs cette heure',
                'email_recipients' => ['admin@lebosstech.com']
            ],
            [
                'name' => 'Taux de Rebond Élevé',
                'type' => 'traffic',
                'metric' => 'bounce_rate',
                'condition' => 'greater_than',
                'threshold' => 70,
                'frequency' => 'daily',
                'message_template' => '⚠️ Taux de rebond élevé: {current_value}%',
                'email_recipients' => ['admin@lebosstech.com']
            ],
            [
                'name' => 'Objectif Ventes Journalier',
                'type' => 'sales',
                'metric' => 'daily_revenue',
                'condition' => 'greater_than',
                'threshold' => 50000,
                'frequency' => 'daily',
                'message_template' => '🎉 Objectif journalier atteint: {current_value} FCFA',
                'email_recipients' => ['admin@lebosstech.com']
            ]
        ];

        foreach ($defaults as $alert) {
            self::firstOrCreate(
                ['name' => $alert['name']],
                $alert
            );
        }
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByFrequency($query, $frequency)
    {
        return $query->where('frequency', $frequency);
    }
}
