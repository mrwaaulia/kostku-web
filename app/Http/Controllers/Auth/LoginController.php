<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function view(){
        return view('pages.auth.login');
    }

    public function sessionLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'penghuni') {
                return redirect()->route('dashboard.penghuni');
            } elseif (Auth::user()->role == 'pengelola') {
                return redirect()->route('dashboard.pengelola');
            } else {
                return redirect()->route('dashboard.superadmin');
            }
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect. Please try again!',
        ]);
    }
}
