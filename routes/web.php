<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('page.movie');
});
Route::get('/homepage', [\App\Http\Controllers\page\landingController::class, 'index'])->name('landing-page');
