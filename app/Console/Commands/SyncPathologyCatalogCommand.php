<?php

namespace App\Console\Commands;

use App\Services\PathologyCatalogSyncService;
use Illuminate\Console\Command;

class SyncPathologyCatalogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pathology:sync-catalog {--overwrite-pricing : Overwrite custom website selling prices with LIS base prices}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize tests, health packages, and departments from Pathology LIS REST API';

    /**
     * Execute the console command.
     */
    public function handle(PathologyCatalogSyncService $syncService): int
    {
        $this->info('Connecting to Pathology LIS API...');

        $overwritePricing = (bool) $this->option('overwrite-pricing');
        if ($overwritePricing) {
            $this->warn('Warning: --overwrite-pricing flag is enabled. Non-locked prices will be updated.');
        }

        $result = $syncService->syncAll($overwritePricing);

        if ($result['success']) {
            $this->info("✅ {$result['message']}");

            return self::SUCCESS;
        }

        $this->error("❌ {$result['message']}");

        return self::FAILURE;
    }
}
