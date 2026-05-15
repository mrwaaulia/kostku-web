<?php

namespace Database\Seeders;

use App\Models\Kamar;
use App\Models\Kost;
use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenghuniSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'penghuni@coba.com';
        $password = 'password';

        $penghuni = User::updateOrCreate(
            ['email' => $email],
            [
                'nama' => 'Penghuni',
                'username' => 'penghuni',
                'telpon' => '081298765432',
                'alamat' => 'Jl. Penghuni No. 1',
                'password' => Hash::make($password),
                'role' => 'penghuni',
            ]
        );
    }
}

