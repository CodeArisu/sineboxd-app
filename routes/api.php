<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Register end point
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
// Login end point
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');

// Logout end point
// it is protected by the sanctum as middleware
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    // // inserts new movies
    // Route::post('/movie/create', [App\Http\Controllers\MovieController::class, 'store'])->name('create-movie');
    // // view inserted movies
    // Route::get('/movie/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->name('show-movie');
    // // deletes existing movies
    // Route::delete('/movie/delete/{movie}', [App\Http\Controllers\MovieController::class, 'destroy'])->name('delete-movie');
    // // updates movie data
    // Route::put('/movie/update/{movie}', [App\Http\Controllers\MovieController::class, 'update'])->name('update-movie');

    // inserts new comments
    Route::post('/movie/{movie}/comment', [App\Http\Controllers\CommentController::class, 'storeComment'])->name('create-comment');
    // deletes new comment
    Route::delete('/movie/{movie}/comment/{comments}', [App\Http\Controllers\CommentController::class, 'deleteComment'])->name('remove-comment');
});

Route::get('/movie/detail/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->name('movie-detail');
Route::post('/movie/detail/{movie}/comment', [App\Http\Controllers\CommentController::class, 'storeComment'])->name('movie-comment');