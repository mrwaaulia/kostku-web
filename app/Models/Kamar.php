<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    // Satu kamar bisa memiliki sejarah banyak penghuni (tapi biasanya 1 yang aktif)
    public function kost() {
        return $this->belongsTo(Kost::class, 'kode_kost', 'id');
    }

        // Kamar mungkin sedang diisi oleh satu User (Penghuni)
    public function penghuni() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
