<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class PenghuniAuthController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'telpon' => 'required|numeric',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'nama' => $request->nama,
            'telpon' => $request->telpon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'role' => 'penghuni',
        ]);
        return redirect()->route('login.penghuni')->withSuccess('Registration successful! You can now login!');
    }

    public function sessionLogin(Request $request){
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'penghuni') {
                return redirect()->route('penghuni.index');
            } elseif (Auth::user()->role == 'pengelola') {
                return redirect()->route('pengelola.index');
            } else {
                return redirect()->route('superadmin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect. Please try again!',
        ]);
    }
}
