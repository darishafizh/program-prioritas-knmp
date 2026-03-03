<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{


    public function edit()
    {
        return view('auth.passwords.change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Password lama tidak sesuai.');
                    }
                }
            ],
            'password' => ['required', 'min:8', 'confirmed', 'different:current_password', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();

        return redirect('/login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
