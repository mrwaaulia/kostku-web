<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\RequestMasukNotification;

class PenghuniAuthController extends Controller
{
    public function viewRegister()
    {
        return view('pages.auth.penghuni.register-penghuni');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|min:3|max:100',
            'telpon'   => 'required|digits_between:11,15',
            'alamat'   => 'required|string|min:10|max:255',
            'email'    => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:32',
        ], [
            'nama.required'          => 'Nama wajib diisi.',
            'nama.min'               => 'Nama minimal 3 karakter.',
            'nama.max'               => 'Nama maksimal 100 karakter.',
            'telpon.required'        => 'Nomor telepon wajib diisi.',
            'telpon.digits_between'  => 'Nomor telepon harus 11-15 digit.',
            'alamat.required'        => 'Alamat wajib diisi.',
            'alamat.min'             => 'Alamat minimal 10 karakter.',
            'alamat.max'             => 'Alamat maksimal 255 karakter.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.max'              => 'Email maksimal 100 karakter.',
            'email.unique'           => 'Email sudah terdaftar.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 8 karakter.',
            'password.max'           => 'Password maksimal 32 karakter.',
        ]);

        $penghuni = User::create([
            'nama'     => $request->nama,
            'telpon'   => $request->telpon,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'alamat'   => $request->alamat,
            'role'     => 'penghuni',
            'status'   => 'Aktif',
        ]);

        return redirect()->route('login')->withSuccess('Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
