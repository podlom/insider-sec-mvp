<?php

namespace database\seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([['email' => 'alice@corp.local', 'name' => 'Alice'], ['email' => 'bob@corp.local', 'name' => 'Bob']] as $u) {
            Employee::firstOrCreate(['email' => $u['email']], ['name' => $u['name']]);
        }
    }
}
