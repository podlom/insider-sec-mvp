<?php

namespace App\Console\Commands;

use App\Models\Incident;
use App\Models\MetricsSnapshot;
use Illuminate\Console\Command;

class MetricsDailySnapshot extends Command
{
    protected $signature = 'metrics:snapshot';

    protected $description = 'Compute daily security metrics (incidents, MTTD/MTTR, losses)';

    public function handle(): int
    {
        $date = now()->toDateString();
        $incidents = Incident::query()->whereDate('created_at', $date)->get();
        $mttd = (int) round($incidents->filter(fn ($i) => $i->detected_at && $i->created_at)->avg(fn ($i) => $i->created_at->diffInMinutes($i->detected_at)) ?: 0);
        $mttr = (int) round($incidents->filter(fn ($i) => $i->resolved_at && $i->detected_at)->avg(fn ($i) => $i->resolved_at->diffInMinutes($i->detected_at)) ?: 0);

        MetricsSnapshot::updateOrCreate(['date' => $date], [
            'incidents_total' => $incidents->count(),
            'incidents_p1' => $incidents->where('severity', 'critical')->count(),
            'median_mttd_minutes' => $mttd ?: null,
            'median_mttr_minutes' => $mttr ?: null,
            'loss_estimated_total' => $incidents->sum('estimated_loss'),
            'mfa_coverage_pct' => 70,
        ]);
        $this->info('Snapshot complete for '.$date);

        return self::SUCCESS;
    }
}
