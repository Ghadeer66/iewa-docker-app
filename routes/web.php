<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');


Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
Route::get('/profile/transactions', [ProfileController::class, 'transactions'])->name('profile.transactions');
Route::get('/profile/wallet', [ProfileController::class, 'wallet'])->name('profile.wallet');
Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
Route::get('/profile/comments', [ProfileController::class, 'comments'])->name('profile.comments');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
