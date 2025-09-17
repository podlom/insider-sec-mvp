<?php
namespace database\seeders;
use App\Models\RiskItem;
use Illuminate\Database\Seeder;

class RiskSeeder extends Seeder {
  public function run(): void {
    RiskItem::firstOrCreate(['title'=>'Insider data exfiltration'], [
      'category'=>'insider','likelihood'=>3,'impact'=>5,'rating'=>15,'treatment'=>'DLP + MFA + monitoring','status'=>'mitigating'
    ]);
  }
}
