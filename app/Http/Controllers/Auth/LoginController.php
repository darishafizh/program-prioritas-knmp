<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Maximum login attempts before lockout.
     */
    protected int $maxAttempts = 5;

    /**
     * Lockout duration in seconds (60 = 1 menit).
     */
    protected int $decaySeconds = 60;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Rate limiting: check if too many attempts
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('username');
        }

        $remember = $request->boolean('remember');

        // Cari user dengan username yang case-sensitive (menggunakan BINARY comparison)
        $user = User::whereRaw('BINARY username = ?', [$credentials['username']])->first();

        // Verifikasi user ditemukan dan password cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {
            RateLimiter::clear($throttleKey);
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }

        // Increment failed attempts
        RateLimiter::hit($throttleKey, $this->decaySeconds);

        $attemptsLeft = RateLimiter::remaining($throttleKey, $this->maxAttempts);

        return back()->withErrors([
            'username' => "Username atau password salah. Sisa percobaan: {$attemptsLeft}.",
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->input('username')) . '|' . $request->ip()
        );
    }
}
