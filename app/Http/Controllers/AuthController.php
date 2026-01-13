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

        $user = \App\Models\User::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username not found.',
            ])->withInput($request->except('password'));
        }

        //check password
        if (!\Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput($request->except('password'));
        }


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->user_type === 'ADMIN') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->user_type === 'STUDENT') {
                return redirect()->intended('/student/dashboard');
            }

            return redirect()->route('/login');

        }

        return back()->withErrors([
            'username' => 'Login failed. Please try again',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }

}


