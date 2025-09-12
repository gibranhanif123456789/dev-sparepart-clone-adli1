<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmins = [
            [
                'name' => 'Nurlela Ginting',
                'email' => 'kainong@example.com',
                'password' => Hash::make('password123'),
                'role' => 1,
                'region' => 'Pusat', // Sesuaikan jika perlu
                'mobile_number' => '081943340628',
                'perusahaan' => 'PT. PGN',
                'noktp' => '12345678',
                'alamat' => 'Jakarta',
                'bagian' => 'Leader Infarstructure Maintenance',
                'atasan' => 'pak bandi',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Septian',
                'email' => 'masseptian@example.com',
                'password' => Hash::make('password123'),
                'role' => 1,
                'region' => 'Pusat',
                'mobile_number' => 'nul',
                'perusahaan' => 'PT. PGN',
                'noktp' => '12345678',
                'alamat' => 'jakarta',
                'bagian' => 'Head of Departement NR',
                'atasan' => 'pak bandi',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($superAdmins as $admin) {
            $existing = DB::table('users')->where('email', $admin['email'])->first();
            if (!$existing) {
                DB::table('users')->insert($admin);
                $this->command->info("Super Admin dibuat: {$admin['email']}");
            } else {
                $this->command->warn("Email sudah ada, dilewati: {$admin['email']}");
            }
        }
    }
}