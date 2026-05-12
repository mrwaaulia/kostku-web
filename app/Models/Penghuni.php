<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penghuni extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'kost_code',
        'entry_date',
        'exit_date',
        'is_problematic',
        'problem_notes'
    ];

    // Relasi ke User (Akun Login)
public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kamar() {
        return $this->belongsTo(Kamar::class, 'nomor_kamar', 'id');
    }
}
