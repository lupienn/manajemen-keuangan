<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $finDept = Department::where('kode', 'FIN')->first();
        $itDept = Department::where('kode', 'IT')->first();

        User::create([
            'username' => 'admin',
            'nama' => 'Administrator',
            'email' => 'admin@perusahaan.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => $finDept->id ?? null,
            'is_active' => true,
        ]);

        User::create([
            'username' => 'manager',
            'nama' => 'Manager Keuangan',
            'email' => 'manager@perusahaan.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'department_id' => $finDept->id ?? null,
            'is_active' => true,
        ]);

        User::create([
            'username' => 'staff',
            'nama' => 'Staff IT',
            'email' => 'staff@perusahaan.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'department_id' => $itDept->id ?? null,
            'is_active' => true,
        ]);
        
        // Generate dummy staff users
        User::factory(10)->create(['department_id' => $itDept->id ?? null]);
    }
}
