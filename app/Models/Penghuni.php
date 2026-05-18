<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kamar;
use App\Models\Kost;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penghuni extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'kost_code',
        'status',
        'tanggal_masuk',
        'tanggal_keluar',
        'is_redflag',
        'problem_notes',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kamar() {
        return $this->belongsTo(Kamar::class, 'room_id');
    }

    public function kost() {
        return $this->belongsTo(Kost::class, 'kost_code', 'kode_kost');
    }
}
