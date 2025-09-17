<?php
namespace database\seeders;
use App\Models\{Control, ControlTest};
use Illuminate\Database\Seeder;

class ControlSeeder extends Seeder {
  public function run(): void {
    $mfa = Control::firstOrCreate(['name'=>'MFA for Admins'], ['family'=>'access','objective'=>'Require MFA for admin accounts','active'=>true]);
    ControlTest::firstOrCreate(['control_id'=>$mfa->id,'tested_on'=>now()->toDateString()], ['passed'=>true,'notes'=>'OK']);
  }
}
