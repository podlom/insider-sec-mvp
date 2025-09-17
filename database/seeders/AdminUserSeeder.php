<?php
namespace database\seeders;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
  public function run(): void
  {
    if (class_exists(User::class)) {
      User::firstOrCreate(['email'=>'admin@example.com'], [
        'name'=>'Admin', 'password'=>Hash::make('password')
      ]);
    }
    Employee::firstOrCreate(['email'=>'admin@example.com'], ['name'=>'Admin']);
  }
}
