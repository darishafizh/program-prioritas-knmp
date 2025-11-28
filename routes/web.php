<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/forms', function () {
    return view('forms.index');
})->name('forms.index');
