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
        return redirect()->route('login')->withSuccess('Registration successful! You can now login!');
    }
}
