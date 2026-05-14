<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
            #return redirect('/loading');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validate input (VERY IMPORTANT)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt login
        if (Auth::attempt($credentials)) {

            // 3. Regenerate session (security fix)
            $request->session()->regenerate();

            #return redirect('/');
              return redirect('/loading'); // module to use the splash screen after login
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // 4. Full session cleanup (good practice)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}