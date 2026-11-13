<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SportsmenRandom;
use App\Http\Controllers\Sportsmens;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware(['web', 'auth', 'set.locale'])->group(function () {
    Route::get('/', [Sportsmens::class, 'index'])->name('home');
    Route::get('/sportsmens', [SportsmenRandom::class, 'index'])->name('sportsmens');
    Route::get('/sportsmen', [SportsmenRandom::class, 'index'])->name('sportsmen');
    Route::view('/contact', 'contact')->name('contact');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('players', PlayerController::class)->except(['show']);
    Route::resource('facts', FactController::class)->except(['show']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('{locale}')->whereIn('locale', ['en', 'tr', 'ru'])->group(function () {
        Route::get('/', [Sportsmens::class, 'index'])->name('locale.home');
        Route::get('/sportsmens', [SportsmenRandom::class, 'index'])->name('locale.sportsmens');
        Route::get('/sportsmen', [SportsmenRandom::class, 'index'])->name('locale.sportsmen');
        Route::view('/contact', 'contact')->name('locale.contact');
    });
});
