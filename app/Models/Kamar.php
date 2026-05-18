<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Penghuni;

class Kamar extends Model
{
    protected $fillable = [
        'nomor_kamar',
        'kode_kost',
        'tipe_kamar',
        'harga',
        'status',
        'fasilitas',
        'user_id',
        'penghuni_id',
    ];

    public function kost() {
        return $this->belongsTo(Kost::class, 'kode_kost', 'id');
    }

    public function penghuni() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penghuniDetail() {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }
}
