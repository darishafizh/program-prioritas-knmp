<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\KeteranganEnumeratorController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TanggapanMasyarakatController;
use App\Models\ProgresPembangunanKnmp;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // ==========================
    // DASHBOARD
    // ==========================
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    // ==========================
    // SURVEY
    // ==========================
    Route::prefix('survey')->group(function () {

        Route::get('/', [SurveyController::class, 'index'])->name('survey.index');

        // ==========================
        // FORMS (ENUMERATOR)
        // ==========================
        Route::prefix('forms')->name('survey.forms.')->group(function () {

            // PENTING: ini dipanggil ketika enumerator membuka form per KNMP
            Route::get('/{knmp}', [FormsController::class, 'index'])->name('index');

            Route::post(
                '/store_profile_knmp/{knmp}',
                [FormsController::class, 'store_profile_knmp']
            )->name('store_profile_knmp');

            Route::post(
                '/store_progres_pembangunan_knmp/{knmp}',
                [FormsController::class, 'store_progres_pembangunan_knmp']
            )->name('store_progres_pembangunan_knmp');

            Route::post(
                '/store_tanggapan_masyarakat/{knmp}',
                [FormsController::class, 'store_tanggapan_masyarakat']
            )->name('store_tanggapan_masyarakat');

            // TIDAK PAKAI PARAMETER — SUDAH BENAR
            Route::post(
                '/store_tingkat_kebahagiaan',
                [FormsController::class, 'store_tingkat_kebahagiaan']
            )->name('store_tingkat_kebahagiaan');

            Route::post(
                '/store_informasi_responden/{knmp}',
                [FormsController::class, 'store_informasi_responden']
            )->name('store_informasi_responden');

            Route::post(
                '/store_informasi_usaha/{knmp}',
                [FormsController::class, 'store_informasi_usaha']
            )->name('store_informasi_usaha');

            Route::post(
                '/store_pemasaran_perikanan/{knmp}',
                [FormsController::class, 'store_pemasaran_perikanan']
            )->name('store_pemasaran_perikanan');

            Route::post(
                '/store_pendapatan_rt/{knmp}',
                [FormsController::class, 'store_pendapatan_rt']
            )->name('store_pendapatan_rt');

            Route::post(
                '/store_sosial_kelembagaan/{knmp}',
                [FormsController::class, 'store_sosial_kelembagaan']
            )->name('store_sosial_kelembagaan');
        });
    });

    // ==========================
    // LAPORAN
    // ==========================
    Route::prefix('laporan')->group(function () {
        Route::get('/', [FormsController::class, 'index'])->name('laporan.index');
    });

    // ==========================
    // USER MANAGEMENT
    // ==========================
    Route::prefix('user_management')->group(function () {
        Route::get('/', [FormsController::class, 'index'])->name('user_management.index');
    });

    // ==========================
    // FORMS MODULE (ADMIN)
    // ==========================
    Route::prefix('forms')->as('forms.')->group(function () {

        // FIX ERROR: formsIndex() HARUS ADA DI CONTROLLER
        Route::get('/', [FormsController::class, 'formsIndex'])->name('index');

        // INFORMASI UMUM
        Route::get('/informasi-umum', [FormsController::class, 'informasiUmum'])->name('informasi_umum');
        Route::get('/informasi-umum/create', [FormsController::class, 'informasiUmumCreate'])->name('informasi_umum.create');
        Route::post('/informasi-umum', [FormsController::class, 'informasiUmumStore'])->name('informasi_umum.store');
        Route::get('/informasi-umum/{id}/edit', [FormsController::class, 'informasiUmumEdit'])
            ->whereNumber('id')->name('informasi_umum.edit');
        Route::put('/informasi-umum/{id}', [FormsController::class, 'informasiUmumUpdate'])
            ->whereNumber('id')->name('informasi_umum.update');
        Route::delete('/informasi-umum/{id}', [FormsController::class, 'informasiUmumDelete'])
            ->whereNumber('id')->name('informasi_umum.delete');

        // KETERANGAN ENUMERATOR
        Route::resource('keterangan-enumerator', KeteranganEnumeratorController::class);

        // TARGET REALISASI
        Route::get('/target-realisasi', [FormsController::class, 'targetRealisasiIndex'])->name('target_realisasi.index');
        Route::get('/target-realisasi/create', [FormsController::class, 'targetRealisasiCreate'])->name('target_realisasi.create');
        Route::post('/target-realisasi', [FormsController::class, 'targetRealisasiStore'])->name('target_realisasi.store');
        Route::get('/target-realisasi/{id}/edit', [FormsController::class, 'targetRealisasiEdit'])
            ->whereNumber('id')->name('target_realisasi.edit');
        Route::put('/target-realisasi/{id}', [FormsController::class, 'targetRealisasiUpdate'])
            ->whereNumber('id')->name('target_realisasi.update');
        Route::delete('/target-realisasi/{id}', [FormsController::class, 'targetRealisasiDelete'])
            ->whereNumber('id')->name('target_realisasi.delete');

        // PROGRES PER KOMPONEN
        Route::get('/progres-per-komponen', [FormsController::class, 'progresPerKomponen'])->name('progres_per_komponen');
        Route::get('/progres-per-komponen/create', [FormsController::class, 'progresPerKomponenCreate'])->name('progres_per_komponen.create');

        // PROFIL KNMP
        Route::get('/profil-knmp', [FormsController::class, 'profilKnmp'])->name('profil_knmp');
        Route::get('/profil-knmp/create', [FormsController::class, 'profilKnmpCreate'])->name('profil_knmp.create');
    });
});
