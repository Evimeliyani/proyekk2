<?php
// database/migrations/YYYY_MM_DD_recreate_presensi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jika tabel presensi masih ada (karena gagal dihapus), ini akan menghapusnya dulu.
        Schema::dropIfExists('presensi');
        
        // Buat tabel presensi baru dengan kolom yang dibutuhkan
        Schema::create('presensi', function (Blueprint $table) { 
            $table->id();
            $table->string('nama'); 
            $table->string('email')->unique();
            $table->string('password');
            $table->string('shift')->nullable(); 
            // Kolom ini kunci untuk Multi-Dashboard!
            $table->string('status')->default('karyawan'); 
            $table->string('aksi')->nullable(); 
            $table->rememberToken();
            
            // Kolom yang menyebabkan error "created_at" hilang
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};