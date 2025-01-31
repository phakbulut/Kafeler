<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('userdashboard.index');
    })->name('dashboard');


    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings.update');

    Route::get('/categories', [DashboardController::class, 'categoriesIndex'])->name('dashboard.categories.index');
    Route::get('/categories/create', [DashboardController::class, 'categoriesCreate'])->name('dashboard.categories.create');
    Route::post('/categories', [DashboardController::class, 'categoriesStore'])->name('dashboard.categories.store');
    Route::post('/categories/bulk-delete', [DashboardController::class, 'categoriesBulkDelete'])->name('dashboard.categories.bulkDelete');
    Route::put('/categories/{category}', [DashboardController::class, 'categoriesUpdate'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [DashboardController::class, 'categoriesDestroy'])->name('dashboard.categories.destroy');
    Route::get('/categories/{category}/edit', [DashboardController::class, 'categoriesEdit'])->name('dashboard.categories.edit');
    Route::post('/categories/{category}/toggle-status', [DashboardController::class, 'categoriesToggleStatus'])->name('dashboard.categories.toggleStatus');

});
