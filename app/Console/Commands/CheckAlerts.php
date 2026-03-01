<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alert;

class CheckAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alerts:check {--frequency=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie et déclenche les alertes selon leur fréquence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $frequency = $this->option('frequency');
        
        $this->info("Vérification des alertes (fréquence: {$frequency})...");
        
        $query = Alert::active();
        
        if ($frequency !== 'all') {
            $query->where('frequency', $frequency);
        }
        
        $alerts = $query->get();
        
        if ($alerts->isEmpty()) {
            $this->info('Aucune alerte active trouvée.');
            return 0;
        }
        
        $triggeredCount = 0;
        
        foreach ($alerts as $alert) {
            $this->line("Vérification: {$alert->name}");
            
            try {
                if ($alert->checkCondition()) {
                    $this->info("  ✓ Alerte déclenchée");
                    $triggeredCount++;
                } else {
                    $this->line("  - Condition non remplie");
                }
            } catch (\Exception $e) {
                $this->error("  ✗ Erreur: {$e->getMessage()}");
            }
        }
        
        $this->info("Vérification terminée. {$triggeredCount} alerte(s) déclenchée(s) sur {$alerts->count()}.");
        
        return 0;
    }
}
