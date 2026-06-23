<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class PengelolaAuthController extends Controller
{
    public function viewRegister()
    {
        return view('pages.auth.pengelola.register-pengelola');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3|max:100',

            'telpon' => [
                'required',
                'digits_between:11,15'
            ],

            'alamat' => 'required|string|min:10|max:255',

            'email' => 'required|email|max:100|unique:users,email',

            'password' => 'required|string|min:8|max:32',

            'nama_kost' => 'required|string|min:3|max:100',

            'alamat_kost' => 'required|string|min:10|max:255',

            'sertifikat' => 'required|file|mimes:pdf|max:10240',
        ], [
            // Nama
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'nama.max' => 'Nama maksimal 100 karakter.',

            // Telepon
            'telpon.required' => 'Nomor telepon wajib diisi.',
            'telpon.digits_between' => 'Nomor telepon harus 11 sampai 15 digit.',

            // Alamat
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 10 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',

            // Email
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            // Password
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 32 karakter.',

            // Nama Kost
            'nama_kost.required' => 'Nama kost wajib diisi.',
            'nama_kost.min' => 'Nama kost minimal 3 karakter.',
            'nama_kost.max' => 'Nama kost maksimal 100 karakter.',

            // Alamat Kost
            'alamat_kost.required' => 'Alamat kost wajib diisi.',
            'alamat_kost.min' => 'Alamat kost minimal 10 karakter.',
            'alamat_kost.max' => 'Alamat kost maksimal 255 karakter.',

            // Sertifikat
            'sertifikat.required' => 'Sertifikat wajib diunggah.',
            'sertifikat.mimes' => 'File harus berformat PDF.',
            'sertifikat.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'telpon'   => $request->telpon,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'alamat'   => $request->alamat,
            'role'     => 'pengelola',
            'status'   => 'Menunggu',
        ]);

        $path = $request->file('sertifikat')->store('sertifikat', 'public');

        $user->kosts()->create([
            'nama_kost'   => $request->nama_kost,
            'alamat_kost' => $request->alamat_kost,
            'sertifikat'  => $path,
            'kode_kost'   => null,
        ]);

        return redirect()->route('register.pengelola')->with('registered', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
