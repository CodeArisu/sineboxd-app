<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/homepage');
});

Route::get('/homepage', [\App\Http\Controllers\page\landingController::class, 'index'])->name('landing-page');

Route::get('/movie/detail/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->name('movie-detail');
Route::post('/movie/detail/{movie}/comment', [App\Http\Controllers\CommentController::class, 'storeComment'])->name('create-comment');