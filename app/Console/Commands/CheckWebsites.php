<?php

namespace App\Console\Commands;

use App\Models\Website;
use App\Services\WebsiteMonitorService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckWebsites extends Command
{
    protected $signature = 'websites:check {--force : Sprawdź wszystkie strony, niezależnie od interwału}';
    protected $description = 'Sprawdź status monitorowanych stron';

    public function handle(WebsiteMonitorService $monitorService)
    {
        $this->info('Rozpoczynam sprawdzanie stron...');

        $query = Website::query()->where('is_active', true);

        if (!$this->option('force')) {
            $query->where(function ($q) {
                $q->whereNull('last_check_at')
                  ->orWhere('last_check_at', '<=', Carbon::now()->subMinutes('check_interval'));
            });
        }

        $websites = $query->get();
        $count = $websites->count();

        if ($count === 0) {
            $this->info('Brak stron do sprawdzenia.');
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($websites as $website) {
            $check = $monitorService->checkWebsite($website);
            
            if ($check->is_up) {
                $this->info("\n✓ {$website->name} jest online (HTTP {$check->status_code})");
            } else {
                $this->error("\n✗ {$website->name} jest offline: {$check->error_message}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\nSprawdzanie zakończone.");
    }
}
