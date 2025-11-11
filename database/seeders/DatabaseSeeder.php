<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'nrp' => 'SA001',
            'jabatan' => 'Super Administrator',
            'pangkat' => '-',
            'email' => 'superadmin@absensi.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin HRD',
            'nrp' => 'AD001',
            'jabatan' => 'Admin Human Resource',
            'pangkat' => 'Staff',
            'email' => 'admin@absensi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Sample Users
        User::create([
            'name' => 'Budi Santoso',
            'nrp' => 'EMP001',
            'jabatan' => 'Software Developer',
            'pangkat' => 'Junior',
            'email' => 'budi@absensi.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'nrp' => 'EMP002',
            'jabatan' => 'UI/UX Designer',
            'pangkat' => 'Middle',
            'email' => 'siti@absensi.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Ahmad Wijaya',
            'nrp' => 'EMP003',
            'jabatan' => 'Project Manager',
            'pangkat' => 'Senior',
            'email' => 'ahmad@absensi.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}