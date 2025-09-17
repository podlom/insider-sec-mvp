<?php
namespace database\seeders;
use App\Models\DetectionRule;
use Illuminate\Database\Seeder;

class DetectionRuleSeeder extends Seeder {
  public function run(): void {
    DetectionRule::firstOrCreate(['name'=>'Off-hours critical repo access'],[
      'description'=>'Login to critical repo off business hours', 'weight'=>15,'severity'=>'medium','enabled'=>true,
      'conditions'=>['logic'=>'all','rules'=>[
        ['field'=>'asset.sensitivity','op'=>'gte','value'=>5],
        ['field'=>'payload.hour','op'=>'in','value'=>[0,1,2,3,4,5]],
      ]]
    ]);
  }
}
