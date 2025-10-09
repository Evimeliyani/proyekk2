<?php
// database/seeders/PresensiSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. AKUN ADMIN
        DB::table('presensi')->insert([
            'nama' => 'Admin Utama',
            'email' => 'admin@presensi.com', 
            'password' => 'admin123', // PASSWORD MENTAH!
            'shift' => null,
            'status' => 'admin', // ROLE: admin
            'aksi' => 'Created',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. AKUN KARYAWAN
        DB::table('presensi')->insert([
            'nama' => 'Karyawan 1',
            'email' => 'karyawan@presensi.com', 
            'password' => 'karyawan123', // PASSWORD MENTAH!
            'shift' => 'Pagi',
            'status' => 'karyawan', // ROLE: karyawan
            'aksi' => 'Created',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}