<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard.index'); })->name('dashboard');
        
    Route::get('/dashboard/informasi-umum', [InformasiUmumController::class, 'create'])->name('informasi_umum.create');
    Route::post('/dashboard/informasi-umum', [InformasiUmumController::class, 'store'])->name('informasi_umum.store');

    // Forms route
    Route::get('/forms', function () { return view('forms.index'); })->name('forms.index');

    // Profile routes
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/dashboard/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/dashboard/profile', [ProfileController::class, 'store'])->name('profile.store');
});
