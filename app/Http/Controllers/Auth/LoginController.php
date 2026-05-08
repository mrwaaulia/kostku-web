<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\User;

class LoginController extends \App\Http\Controllers\Controller
{
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
            return redirect()->route('dashboard.pengelola');
        } else {
            return redirect()->route('superadmin.dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Email or password is incorrect. Please try again!',
    ]);
    }
}
