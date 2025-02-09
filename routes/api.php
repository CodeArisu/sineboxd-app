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

    Route::post('/movie/create', [App\Http\Controllers\MoviewController::class, 'store'])->name('create-movie');
    Route::get('/movie/{moviews}', [App\Http\Controllers\MoviewController::class, 'show'])->name('show-movie');

    Route::delete('/movie/delete/{moviews}', [App\Http\Controllers\MoviewController::class, 'destroy'])->name('delete-movie');
});

Route::put('/movie/update/{moviews}', [App\Http\Controllers\MoviewController::class, 'update'])->name('update-movie');