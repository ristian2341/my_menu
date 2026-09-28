<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserMenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Clean Architecture
|--------------------------------------------------------------------------
*/

// Root redirect
Route::get('/', fn () => redirect()->route('dashboard'));

// ── Guest ────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'show'])->name('login');
    Route::post('/login',   [LoginController::class,    'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->name('register.store');
});

// ── Authenticated ─────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Menu Items — CRUD
    Route::resource('menu', MenuItemController::class);
    Route::patch('menu/{menu}/toggle', [MenuItemController::class, 'toggle'])->name('menu.toggle');

    // User Groups — CRUD
    Route::resource('groups', UserGroupController::class);

    // User Menus — CRUD
    Route::resource('user-menus', UserMenuController::class);
    Route::patch('user-menus/{userMenu}/toggle', [UserMenuController::class, 'toggle'])->name('user-menus.toggle');
});

