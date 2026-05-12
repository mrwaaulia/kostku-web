<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = [
        'kode_kost',
        'nama_kost',
        'alamat_kost',
        'sertifikat',
        'user_id',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Kost memiliki banyak Kamar
    public function kamars() {
        return $this->hasMany(Kamar::class, 'kode_kost', 'id');
    }
}
