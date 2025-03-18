<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/homepage');
});

Route::get('/homepage', [\App\Http\Controllers\page\landingController::class, 'index'])->name('landing-page');

Route::get('/movie/detail/{movie}', [App\Http\Controllers\CommentController::class, 'showComment'])->name('movie-comments');
Route::post('/movie/detail/{movie}/comment', [App\Http\Controllers\CommentController::class, 'storeComment'])->name('create-comment');
Route::put('/movie/detail/{movie}/{comment}/update', [App\Http\Controllers\CommentController::class, 'updateComment'])->name('update-comment');
Route::delete('/movie/detail/{comment}/delete', [App\Http\Controllers\CommentController::class, 'deleteComment'])->name('remove-comment');