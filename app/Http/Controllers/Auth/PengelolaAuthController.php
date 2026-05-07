<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PengelolaAuthController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telpon' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'nama_kost' => 'required|string|max:255',
            'alamat_kost' => 'required|string|max:255',
            'sertifikat' => 'required|file|max:10240|mimes:pdf',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'telpon' => $request->telpon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'role' => 'pengelola',
            'nama_kost' => $request->nama_kost,
            'alamat_kost' => $request->alamat_kost,
            'sertifikat' => $request->file('sertifikat')->store('sertifikat', 'public')
        ]);

        return redirect()->route('login')->withSuccess('Registration successful! You can now login!');
    }
}
