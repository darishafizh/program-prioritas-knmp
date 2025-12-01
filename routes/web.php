<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\KeteranganEnumeratorController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Dashboard - Informasi Umum
    Route::get('/dashboard/informasi-umum', [InformasiUmumController::class, 'create'])
        ->name('informasi_umum.create');
    Route::post('/dashboard/informasi-umum', [InformasiUmumController::class, 'store'])
        ->name('informasi_umum.store');

    // Dashboard - Profile
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/dashboard/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/dashboard/profile', [ProfileController::class, 'store'])->name('profile.store');

    // ==============================
    // FORM ROUTES
    // ==============================
    Route::prefix('forms')->as('forms.')->group(function () {

        // Halaman utama Forms
        Route::get('/', [FormsController::class, 'index'])->name('index');

        // -----------------------------------------
        // INFORMASI UMUM
        // -----------------------------------------
        Route::get('/informasi-umum', [FormsController::class, 'informasiUmum'])
            ->name('informasi_umum');
        Route::get('/informasi-umum/create', [FormsController::class, 'informasiUmumCreate'])
            ->name('informasi_umum.create');
        Route::post('/informasi-umum', [FormsController::class, 'informasiUmumStore'])
            ->name('informasi_umum.store');
        Route::get('/informasi-umum/{id}/edit', [FormsController::class, 'informasiUmumEdit'])
            ->whereNumber('id')->name('informasi_umum.edit');
        Route::put('/informasi-umum/{id}', [FormsController::class, 'informasiUmumUpdate'])
            ->whereNumber('id')->name('informasi_umum.update');
        Route::delete('/informasi-umum/{id}', [FormsController::class, 'informasiUmumDelete'])
            ->whereNumber('id')->name('informasi_umum.delete');

        // -----------------------------------------
        // KETERANGAN ENUMERATOR (RESOURCE)
        // -----------------------------------------
        Route::resource('keterangan-enumerator', KeteranganEnumeratorController::class);

        // -----------------------------------------
        // TARGET REALISASI
        // -----------------------------------------
        Route::get('/target-realisasi', [FormsController::class, 'targetRealisasiIndex'])
            ->name('target_realisasi.index');

        Route::get('/target-realisasi/create', [FormsController::class, 'targetRealisasiCreate'])
            ->name('target_realisasi.create');

        Route::post('/target-realisasi', [FormsController::class, 'targetRealisasiStore'])
            ->name('target_realisasi.store');

        Route::get('/target-realisasi/{id}/edit', [FormsController::class, 'targetRealisasiEdit'])
            ->whereNumber('id')->name('target_realisasi.edit');

        Route::put('/target-realisasi/{id}', [FormsController::class, 'targetRealisasiUpdate'])
            ->whereNumber('id')->name('target_realisasi.update');

        Route::delete('/target-realisasi/{id}', [FormsController::class, 'targetRealisasiDelete'])
            ->whereNumber('id')->name('target_realisasi.delete');

        // -----------------------------------------
        // PROGRES PER KOMPONEN
        // -----------------------------------------
        Route::get('/progres-per-komponen', [FormsController::class, 'progresPerKomponen'])
            ->name('progres_per_komponen');
        Route::get('/progres-per-komponen/create', [FormsController::class, 'progresPerKomponenCreate'])
            ->name('progres_per_komponen.create');

        // -----------------------------------------
        // PROFIL KNMP
        // -----------------------------------------
        Route::get('/profil-knmp', [FormsController::class, 'profilKnmp'])
            ->name('profil_knmp');
        Route::get('/profil-knmp/create', [FormsController::class, 'profilKnmpCreate'])
            ->name('profil_knmp.create');
    });
});
