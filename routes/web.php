<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\KeteranganEnumeratorController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\RespondenController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform')->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware('auth')->group(function () {

    // Change Password Routes
    Route::get('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'edit'])->name('password.change');
    Route::post('password/change', [App\Http\Controllers\Auth\ChangePasswordController::class, 'update'])->name('password.change.update');

    // ==============================
    // DASHBOARD ROUTES (NO PREFIX)
    // ==============================


    // ==============================
    // DASHBOARD ROUTES
    // ==============================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



    // ==============================
    // SURVEY ROUTES
    // ==============================
    Route::group(['prefix' => 'survey'], function () {
        Route::get('/', [SurveyController::class, 'index'])->name('survey.index');

        // ==============================
        // FORMS ROUTES
        // ==============================
        Route::group(['prefix' => 'forms'], function () {
            Route::get('/{knmp}', [FormsController::class, 'index'])->name('forms.index');
            Route::get('/{knmp}/edit-responden', [RespondenController::class, 'editRespondenList'])->name('forms.edit-responden');
            Route::delete('/delete-responden', [RespondenController::class, 'delete_responden'])->name('forms.delete_responden');

            // Store routes
            Route::post('/store_profile_knmp/{knmp}', [FormsController::class, 'store_profile_knmp'])->name('forms.store_profile_knmp');
            Route::post('/store_progres_knmp/{knmp}', [FormsController::class, 'store_progres_knmp'])->name('forms.store_progres_knmp');
            Route::post(
                '/store_tanggapan_masyarakat/{knmp}',
                [FormsController::class, 'store_tanggapan_masyarakat']
            )->name('forms.store_tanggapan_masyarakat');
            Route::post('/store_tingkat_kebahagiaan/{knmp}', [FormsController::class, 'store_tingkat_kebahagiaan'])->name('forms.store_tingkat_kebahagiaan');
            Route::post('/store_informasi_responden/{knmp}', [RespondenController::class, 'store_informasi_responden'])->name('forms.store_informasi_responden');
            Route::post('/store_informasi_usaha/{knmp}', [FormsController::class, 'store_informasi_usaha'])->name('forms.store_informasi_usaha');
            Route::post('/store_pemasaran_perikanan/{knmp}', [FormsController::class, 'store_pemasaran_perikanan'])->name('forms.store_pemasaran_perikanan');
            Route::post('/store_pendapatan_rt/{knmp}', [FormsController::class, 'store_pendapatan_rt'])->name('forms.store_pendapatan_rt');
            Route::post('/store_sosial_kelembagaan/{knmp}', [FormsController::class, 'store_sosial_kelembagaan'])->name('forms.store_sosial_kelembagaan');

            // Edit/Update routes
            Route::post('/update_profile_knmp/{knmp}', [FormsController::class, 'update_profile_knmp'])->name('forms.update_profile_knmp');
            Route::post('/update_progres_knmp/{knmp}', [FormsController::class, 'update_progres_knmp'])->name('forms.update_progres_knmp');
            Route::post('/update_tanggapan_masyarakat/{knmp}', [FormsController::class, 'update_tanggapan_masyarakat'])->name('forms.update_tanggapan_masyarakat');

            // File upload routes
            Route::post('/bukti-upload', [EvidenceController::class, 'store_bukti_upload'])
                ->name('forms.store_bukti_upload');
            Route::delete('/bukti-upload', [EvidenceController::class, 'delete_bukti_upload'])
                ->name('forms.delete_bukti_upload');
            Route::delete('/bukti-upload/{id}', [EvidenceController::class, 'delete_bukti_single'])
                ->name('forms.delete_bukti_single');

            // Evidence & PDF routes
            Route::get('/evidence/{knmp}', [EvidenceController::class, 'evidence'])
                ->name('survey.evidence');
            Route::get('/questionnaires-pdf/{knmp}', [ReportController::class, 'questionnairesListPdf'])
                ->name('survey.questionnaires-pdf');
            Route::get('/questionnaire-pdf/{knmp}/{responden}', [ReportController::class, 'generateRespondenQuestionnairesPdf'])
                ->name('survey.questionnaire-pdf');

            // Export Excel route
            Route::get('/export-excel/{knmp?}', [RespondenController::class, 'exportExcel'])
                ->name('forms.export-excel');
        });
    });


    // ==============================
    // REPORT ROUTES
    // ==============================
    Route::group(['prefix' => 'laporan'], function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // ==============================
    // ACTIVITY LOG ROUTES (Admin Only)
    // ==============================
    Route::group(['prefix' => 'activity-log', 'middleware' => 'role:admin'], function () {
        Route::get('/', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-log.index');
    });

    // Note: survey.evidence route already defined above in survey/forms group



    // ==============================
    // USER MANAGEMENT ROUTES
    // ==============================
    Route::group(['prefix' => 'user_management'], function () {
        Route::get('/', [FormsController::class, 'index'])->name('user_management.index');
    });


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
