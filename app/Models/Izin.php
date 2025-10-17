<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{

    protected $table = 'izin';

    protected $fillable = [
        'user_id',
        'tanggal_izin',
        'jenis_izin',
        'alasan',
        'status',
    ];

    // relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
