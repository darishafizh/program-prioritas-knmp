<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
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

        $remember = $request->boolean('remember');

        // Cari user dengan username yang case-sensitive (menggunakan BINARY comparison)
        $user = User::whereRaw('BINARY username = ?', [$credentials['username']])->first();

        // Verifikasi user ditemukan dan password cocok
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }

        return back()->withErrors(["username" => "Username atau password salah."])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
