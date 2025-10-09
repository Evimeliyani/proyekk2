<?php
// database/migrations/YYYY_MM_DD_create_riwayat_absensi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_absensi', function (Blueprint $table) {
            $table->id();
            // Kunci asing ke tabel 'presensi' (karyawan). Sesuaikan nama kolom jika beda.
            $table->foreignId('presensi_id')->constrained('presensi')->onDelete('cascade');
            
            $table->date('tanggal'); // Kolom TANGGAL
            $table->time('jam_masuk')->nullable(); // Kolom JAM MASUK (nullable jika Alfa/Izin)
            $table->string('keterangan'); // Kolom KETERANGAN (Hadir, Alfa, Terlambat, Izin)

            // Kombinasi untuk memastikan 1 karyawan hanya 1 absensi per hari
            $table->unique(['presensi_id', 'tanggal']); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_absensi');
    }
};