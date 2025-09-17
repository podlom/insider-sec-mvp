<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\DetectionRule;
use App\Models\Employee;
use Illuminate\Console\Command;

class DemoSeedData extends Command
{
    protected $signature = 'demo:seed';

    protected $description = 'Seed demo employees, assets, rules';

    public function handle(): int
    {
        Employee::firstOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin']);
        foreach ([
            ['name' => 'Billing DB', 'type' => 'db', 'sensitivity' => 5],
            ['name' => 'Customer Fileshare', 'type' => 'file_share', 'sensitivity' => 4],
            ['name' => 'Source Repo', 'type' => 'repo', 'sensitivity' => 5],
        ] as $a) {
            Asset::firstOrCreate(['name' => $a['name']], $a);
        }

        DetectionRule::firstOrCreate(['name' => 'Mass export > 500MB/hour'], [
            'description' => 'Unusual export volume', 'weight' => 20, 'severity' => 'high', 'enabled' => true,
            'conditions' => ['logic' => 'all', 'rules' => [
                ['field' => 'payload.size_mb', 'op' => 'gte', 'value' => 500],
                ['field' => 'event_type', 'op' => 'eq', 'value' => 'export'],
            ]],
        ]);
        $this->info('Demo data seeded');

        return self::SUCCESS;
    }
}
