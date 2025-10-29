<?php

// app/Models/Absensi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','tanggal','shift','jam_masuk','status'];

    protected $casts = [
        'tanggal'   => 'datetime',
        'jam_masuk' => 'datetime:H:i',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

