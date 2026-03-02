<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        $roles = Role::all();

        return view('user_management.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()],
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user_management.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()],
            'role' => 'required|exists:roles,name',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update role
        $user->roles()->detach();
        $user->assignRole($request->role);

        return redirect()->route('user_management.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Don't allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('user_management.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->roles()->detach();
        $user->delete();

        return redirect()->route('user_management.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
