<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\MealImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SectionElementController;
use App\Http\Controllers\Admin\SectionTypeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Business\AuthController as BusinessAuthController;
use App\Http\Controllers\Business\DashboardController as BusinessDashboardController;
use App\Http\Controllers\Business\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ----------------------
// Public Routes
// ----------------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/user', [AuthController::class, 'user']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// ----------------------
// Protected User Routes
// ----------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::get('/profile/transactions', [ProfileController::class, 'transactions'])->name('profile.transactions');
    Route::get('/profile/wallet', [ProfileController::class, 'wallet'])->name('profile.wallet');
    Route::get('/profile/comments', [ProfileController::class, 'comments'])->name('profile.comments');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
});

// ----------------------
// Business Routes
// ----------------------
Route::prefix('business')->group(function () {
    // Auth
    Route::get('/login', [BusinessAuthController::class, 'showLoginForm'])->name('business.login');
    Route::post('/login', [BusinessAuthController::class, 'login']);
    Route::get('/register', [BusinessAuthController::class, 'showRegisterForm'])->name('business.register');
    Route::post('/register', [BusinessAuthController::class, 'register']);
    Route::post('/logout', [BusinessAuthController::class, 'logout'])->name('business.logout');

    // Protected
    Route::middleware(['auth', 'role:business'])->group(function () {
        Route::get('/dashboard', [BusinessDashboardController::class, 'index'])->name('business.dashboard');
        Route::post('/employees/upload', [EmployeeController::class, 'uploadCsv'])->name('business.employees.upload');
        Route::post('/employees/{user}/subsidy', [EmployeeController::class, 'setSubsidy'])->name('business.employees.subsidy');
        Route::post('/employees/subsidy-by-code', [EmployeeController::class, 'setSubsidyByCode'])->name('business.employees.subsidyByCode');
        // Client management (edit/delete) handled from dashboard
        Route::put('/employees/{user}', [BusinessDashboardController::class, 'updateClient'])->name('business.employees.update');
        Route::delete('/employees/{user}', [BusinessDashboardController::class, 'destroyClient'])->name('business.employees.destroy');
    });
});

// ----------------------
// Admin Routes
// ----------------------
Route::prefix('admin')->group(function () {
    // Auth
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // /admin landing page → redirect to dashboard
    Route::get('/', fn() => redirect()->route('admin.dashboard'))->name('admin.index');

    // Protected Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Users
        Route::get('/users/admins', [AdminUserController::class, 'index'])->name('admin.admins.index');
        Route::post('/users/admins', [AdminUserController::class, 'store'])->name('admin.admins.store');
        Route::put('/users/admins/{user}', [AdminUserController::class, 'update'])->name('admin.admins.update');
        Route::delete('/users/admins/{user}', [AdminUserController::class, 'destroy'])->name('admin.admins.destroy');


        Route::get('/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
        Route::post('/companies', [CompanyController::class, 'store'])->name('admin.companies.store');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');


        // Admin Clients
        Route::get('/users/clients', fn() => Inertia::render('Admin/Clients'));
        Route::post('/users/clients', [ClientController::class, 'store'])->name('admin.clients.store');
        Route::put('/users/clients/{user}', [ClientController::class, 'update'])->name('admin.clients.update');

        // Site Components
        Route::get('/meals', fn() => Inertia::render('Admin/Meals'));
        Route::get('/meals-images', fn() => Inertia::render('Admin/MealsImages'));
        Route::get('/images', fn() => Inertia::render('Admin/Images'));
        Route::get('/orders', fn() => Inertia::render('Admin/Orders'));
        Route::get('/packages', fn() => Inertia::render('Admin/Packages'));
        Route::get('/types', fn() => Inertia::render('Admin/Types'));
        Route::get('/section-types', fn() => Inertia::render('Admin/SectionTypes'));
        Route::get('/section-elements', fn() => Inertia::render('Admin/SectionElements'));
        Route::resource('ingredients', IngredientController::class)->only(['index', 'store', 'destroy']);


        // Users - Companies
        Route::get('/users/companies', [CompanyController::class, 'index'])->name('admin.companies.index');
        Route::delete('/users/companies/{user}', [CompanyController::class, 'destroy'])->name('admin.companies.destroy');

        // Users - Clients
        Route::get('/users/clients', [ClientController::class, 'index'])->name('admin.clients.index');
        Route::delete('/users/clients/{user}', [ClientController::class, 'destroy'])->name('admin.clients.destroy');

        // Site Components Routes
        Route::get('/meals', [MealController::class, 'index'])->name('admin.meals.index');
        Route::post('/meals', [MealController::class, 'store'])->name('admin.meals.store');
        Route::put('/meals/{meal}', [MealController::class, 'update'])->name('admin.meals.update');
        Route::delete('/meals/{meal}', [MealController::class, 'destroy'])->name('admin.meals.destroy');

        Route::get('/meals-images', [MealImageController::class, 'index'])->name('admin.meals-images.index');
        Route::post('/meals-images', [MealImageController::class, 'store'])->name('admin.meals-images.store');
        Route::delete('/meals-images/{mealImage}', [MealImageController::class, 'destroy'])->name('admin.meals-images.destroy');

        Route::get('/images', [ImageController::class, 'index'])->name('admin.images.index');
        Route::post('/images', [ImageController::class, 'store'])->name('admin.images.store');
        Route::put('/images/{image}', [ImageController::class, 'update'])->name('admin.images.update');
        Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('admin.images.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

        Route::get('/packages', [PackageController::class, 'index'])->name('admin.packages.index');
        Route::post('/packages', [PackageController::class, 'store'])->name('admin.packages.store');
        Route::put('/packages/{package}', [PackageController::class, 'update'])->name('admin.packages.update');
        Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');

        Route::get('/types', [TypeController::class, 'index'])->name('admin.types.index');
        Route::post('/types', [TypeController::class, 'store'])->name('admin.types.store');
        Route::put('/types/{type}', [TypeController::class, 'update'])->name('admin.types.update');
        Route::delete('/types/{type}', [TypeController::class, 'destroy'])->name('admin.types.destroy');

        Route::get('/section-types', [SectionTypeController::class, 'index'])->name('admin.section-types.index');
        Route::post('/section-types', [SectionTypeController::class, 'store'])->name('admin.section-types.store');
        Route::put('/section-types/{sectionType}', [SectionTypeController::class, 'update'])->name('admin.section-types.update');
        Route::delete('/section-types/{sectionType}', [SectionTypeController::class, 'destroy'])->name('admin.section-types.destroy');

        Route::get('/section-elements', [SectionElementController::class, 'index'])->name('admin.section-elements.index');
        Route::post('/section-elements', [SectionElementController::class, 'store'])->name('admin.section-elements.store');
        Route::put('/section-elements/{sectionElement}', [SectionElementController::class, 'update'])->name('admin.section-elements.update');
        Route::delete('/section-elements/{sectionElement}', [SectionElementController::class, 'destroy'])->name('admin.section-elements.destroy');
    });
});

// ----------------------
// Default dashboard
// ----------------------
Route::get('dashboard', fn() => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
