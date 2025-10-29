<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');                 // hari absen
            $table->string('shift')->nullable();     // Pagi/Siang/Malam (opsional)
            $table->time('jam_masuk')->nullable();   // jam datang (opsional)
            $table->enum('status', ['Hadir','Alfa','Izin','Terlambat'])->index();
            $table->timestamps();

            $table->unique(['user_id','tanggal']);   // cegah dobel per hari
            $table->index('tanggal');
        });
    }

    public function down(): void {
        Schema::dropIfExists('absensis');
    }
};
