<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Panggil PresensiSeeder untuk mengisi data Admin dan Karyawan
        $this->call([
            PresensiSeeder::class,
        ]);
    }
}