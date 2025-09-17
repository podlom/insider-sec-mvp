<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\{Employee, Asset, SecurityEvent};
use App\Services\Rules\RuleEvaluator;

class SecurityEventsImport extends Command
{
    protected $signature = 'security:events:import {--file=security_events.csv}';
    protected $description = 'Import security events from CSV and evaluate rules';

    public function handle(RuleEvaluator $evaluator): int
    {
        $path = storage_path('app/'.$this->option('file'));
        if (!file_exists($path)) { $this->error('File not found: '.$path); return self::FAILURE; }
        $csv = Reader::createFromPath($path); $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $row) {
            $employee = !empty($row['employee_email']) ? Employee::firstOrCreate(['email'=>$row['employee_email']], ['name'=>$row['employee_email']]) : null;
            $asset = !empty($row['asset_name']) ? Asset::firstOrCreate(['name'=>$row['asset_name']], ['type'=>'file_share','sensitivity'=>3]) : null;
            $event = SecurityEvent::create([
                'employee_id' => $employee?->id,
                'asset_id'    => $asset?->id,
                'source'      => $row['source'] ?? 'csv',
                'event_type'  => $row['event_type'] ?? 'unknown',
                'payload'     => json_decode($row['payload_json'] ?? '[]', true),
                'occurred_at' => $row['occurred_at'] ?? now(),
            ]);
            $evaluator->evaluate($event);
        }
        $this->info('Import complete.');
        return self::SUCCESS;
    }
}
