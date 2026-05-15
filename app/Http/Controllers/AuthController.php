<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Login
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        // 1. Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Rate limiting key
        $key = 'login:' . $request->ip();

        // 3. Too many attempts protection (IMPORTANT SECURITY FIX)
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again later.',
            ]);
        }

        // 4. Attempt login
        if (Auth::attempt($credentials)) {

            // reset rate limiter on success
            RateLimiter::clear($key);

            // regenerate session (prevents session fixation)
            $request->session()->regenerate();

            // OPTIONAL: role-based redirect hook (safe fallback kept)
            return redirect('/loading');
        }

        // 5. Increment failed attempts
        RateLimiter::hit($key, 60); // lock for 60 seconds window behavior

        return back()
            ->withErrors([
                'email' => 'Invalid credentials.',
            ])
            ->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}