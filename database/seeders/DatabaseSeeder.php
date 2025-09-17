<?php
namespace database\seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    $this->call([ AdminUserSeeder::class, EmployeeSeeder::class, AssetSeeder::class, DetectionRuleSeeder::class, ControlSeeder::class, RiskSeeder::class ]);
  }
}
