<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'status',
        'tanggapan'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
