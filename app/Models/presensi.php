<?php
// app/Models/Presensi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Presensi extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'presensi'; 

    protected $fillable = [
        'nama',
        'email',
        'password',
        'shift',
        'status', 
        'aksi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Hapus atau Komentar di sini: Tidak ada fitur hashing otomatis
    /*
    protected $casts = [
        'password' => 'hashed', 
    ];
    */
}