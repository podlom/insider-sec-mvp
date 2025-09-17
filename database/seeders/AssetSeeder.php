<?php
namespace database\seeders;
use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder {
  public function run(): void {
    foreach ([
      ['name'=>'Prod DB','type'=>'db','sensitivity'=>5],
      ['name'=>'SaaS Drive','type'=>'saas','sensitivity'=>3],
    ] as $a) {
      Asset::firstOrCreate(['name'=>$a['name']], $a);
    }
  }
}
