<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');
Route::get('/catalog/modules', [CatalogController::class, 'indexModules'])->name('catalog.modules');
Route::get('/catalog/frames', [CatalogController::class, 'indexFrames'])->name('catalog.frames');

Route::middleware('auth')->controller(SchemeController::class)->group(function () {
    Route::get('/schemes', 'index')->name('schemes.index');
    Route::post('/frames/{frame}/schemes', 'store')->name('schemes.store');
    Route::get('/schemes/{scheme}', 'show')->name('schemes.show');
    Route::delete('/schemes/{scheme}', 'destroy')->name('schemes.destroy');
    Route::post('/schemes/{scheme}/installations', 'addModule')->name('schemes.install');
    Route::delete('/schemes/{scheme}/installations/{installation}', 'removeModule')->whereNumber('installation')->name('schemes.remove');
});

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

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// --------------- MODULE PAGE

Route::get('/modules/{module}', [CatalogController::class, 'show'])->name('modules.show');
Route::middleware('auth')->controller(WishlistController::class)->group(function () {
    Route::put('/wishlist/{module}', 'store')->name('wishlist.store');
    Route::delete('/wishlist/{module}', 'destroy')->name('wishlist.destroy');
});
