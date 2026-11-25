<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

// --------------- AUTH

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return Inertia::render('auth/Register');
    })->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', function () {
        return Inertia::render('auth/Login');
    })->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
