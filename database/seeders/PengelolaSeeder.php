<?php

namespace Database\Seeders;

use App\Models\Kost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengelolaSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'pengelola@coba.com';
        $password = 'password';

        $pengelola = User::updateOrCreate(
            ['email' => $email],
            [
                'nama' => 'Pengelola',
                'username' => 'pengelola',
                'telpon' => '081234567890',
                'alamat' => 'Jl. Bandung No. 1',
                'password' => Hash::make($password),
                'role' => 'pengelola',
            ]
        );


        $kodeKost = 'KST-PELOGELA-001';

        Kost::updateOrCreate(
            ['kode_kost' => $kodeKost],

            [
                'user_id' => $pengelola->id,
                'nama_kost' => 'Kost Contoh (Seeder)',
                'alamat_kost' => 'Jl. Kost Contoh',
                'sertifikat' => null,

            ]
        );

    }
}

