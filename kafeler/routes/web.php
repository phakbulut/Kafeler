<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cafe/{slug}', [HomeController::class, 'showCafe'])->name('cafe.show')->middleware('track.clicks');
Route::get('/search-cafes', [HomeController::class, 'searchCafes'])->name('search.cafes'); //bu rotanın tıklamaları loglanıyor
Route::get('/cafe/{cafeSlug}/{categorySlug}', action: [HomeController::class, 'showCategoryProducts'])->name('cafe.category.products');

Route::get('/qr/{cafeSlug}/', function ($cafeSlug) {
    $url = route('cafe.show', $cafeSlug);
    $qrCode = new QrCode($url);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    return response($result->getString())
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="qrcode.png"');
})->name('generate.qr');

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
    

    Route::get('/dashboard', action: [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/settings', action: [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.settings.update');
    Route::post('/toggle-status', [DashboardController::class, 'userToggleStatus'])->name('dashboard.toggle.status');

    Route::get('/categories', [DashboardController::class, 'categoriesIndex'])->name('dashboard.categories.index');
    Route::get('/categories/create', [DashboardController::class, 'categoriesCreate'])->name('dashboard.categories.create');
    Route::post('/categories', [DashboardController::class, 'categoriesStore'])->name('dashboard.categories.store');
    Route::post('/categories/bulk-delete', [DashboardController::class, 'categoriesBulkDelete'])->name('dashboard.categories.bulkDelete');
    Route::put('/categories/{category}', [DashboardController::class, 'categoriesUpdate'])->name('dashboard.categories.update');
    Route::delete('/categories/{category}', [DashboardController::class, 'categoriesDestroy'])->name('dashboard.categories.destroy');
    Route::get('/categories/{category}/edit', [DashboardController::class, 'categoriesEdit'])->name('dashboard.categories.edit');
    Route::post('/categories/{category}/toggle-status', [DashboardController::class, 'categoriesToggleStatus'])->name('dashboard.categories.toggleStatus');

    Route::get('/products', [DashboardController::class, 'productsIndex'])->name('dashboard.products.index');
    Route::get('/products/create', [DashboardController::class, 'productsCreate'])->name('dashboard.products.create');
    Route::post('/products', [DashboardController::class, 'productsStore'])->name('dashboard.products.store');
    Route::get('/products/{product}/edit', [DashboardController::class, 'productsEdit'])->name('dashboard.products.edit');
    Route::put('/products/{product}', [DashboardController::class, 'productsUpdate'])->name('dashboard.products.update');
    Route::delete('/products/{product}', [DashboardController::class, 'productsDestroy'])->name('dashboard.products.destroy');
    Route::post('/products/bulk-delete', [DashboardController::class, 'productsBulkDelete'])->name('dashboard.products.bulkDelete');
    Route::post('/products/{product}/toggle-status', [DashboardController::class, 'toggleStatus'])->name('dashboard.products.toggleStatus');
    Route::delete('/products/remove-image/{image}', [DashboardController::class, 'removeImage'])->name('dashboard.products.removeImage');

    Route::get('/banners', [DashboardController::class, 'bannersIndex'])->name('dashboard.banners.index');
    Route::get('/banners/create', [DashboardController::class, 'bannersCreate'])->name('dashboard.banners.create');
    Route::post('/banners', [DashboardController::class, 'bannersStore'])->name('dashboard.banners.store');
    Route::get('/banners/{banner}/edit', [DashboardController::class, 'bannersEdit'])->name('dashboard.banners.edit');
    Route::put('/banners/{banner}', [DashboardController::class, 'bannersUpdate'])->name('dashboard.banners.update');
    Route::delete('/banners/{banner}', [DashboardController::class, 'bannersDestroy'])->name('dashboard.banners.destroy');
    Route::post('/banners/bulk-delete', [DashboardController::class, 'bannersBulkDelete'])->name('dashboard.banners.bulkDelete');
    Route::post('/banners/{banner}/toggle-status', [DashboardController::class, 'bannersToggleStatus'])->name('dashboard.banners.toggleStatus');
});
