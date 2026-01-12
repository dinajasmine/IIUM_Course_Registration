<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login'); 
    }
    
    

    public function login(Request $request)
    {
        $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        $user = Auth::user();

        if ($user->user_type === 'ADMIN') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->user_type === 'STUDENT') {
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}


