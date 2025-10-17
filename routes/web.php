<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Business\AuthController as BusinessAuthController;
use App\Http\Controllers\Business\DashboardController;
use App\Http\Controllers\Business\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;


// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']);


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');


// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::get('/profile/transactions', [ProfileController::class, 'transactions'])->name('profile.transactions');
    Route::get('/profile/wallet', [ProfileController::class, 'wallet'])->name('profile.wallet');
    Route::get('/profile/comments', [ProfileController::class, 'comments'])->name('profile.comments');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
});

Route::get('/business', function () {
    return inertia('Business/Index');
});
// Business Routes
Route::prefix('business')->group(function () {
    // Auth Routes
    Route::get('/login', [BusinessAuthController::class, 'showLoginForm'])->name('business.login');
    Route::post('/login', [BusinessAuthController::class, 'login']);
    Route::get('/register', [BusinessAuthController::class, 'showRegisterForm'])->name('business.register');
    Route::post('/register', [BusinessAuthController::class, 'register']);
    Route::post('/logout', [BusinessAuthController::class, 'logout'])->name('business.logout');

    // Protected Business Routes
    Route::middleware(['auth', 'role:business'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('business.dashboard');
        // Employees: CSV upload and subsidy management
        Route::post('/employees/upload', [EmployeeController::class, 'uploadCsv'])->name('business.employees.upload');
        Route::post('/employees/{user}/subsidy', [EmployeeController::class, 'setSubsidy'])->name('business.employees.subsidy');
        Route::post('/employees/subsidy-by-code', [EmployeeController::class, 'setSubsidyByCode'])->name('business.employees.subsidyByCode');
    });
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
