<?php

use Illuminate\Support\Facades\Route;

// Public Controller
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Guest\EventController;
use App\Http\Controllers\Guest\CreatorController;
use App\Http\Controllers\Guest\HelpController;
use App\Http\Controllers\Guest\BlogController;

// User Controller (Pastikan alias ini digunakan di bawah)
use App\Http\Controllers\User\TiketController as UserTiketController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\PengaturanController as UserPengaturanController;

// Creator Controller
use App\Http\Controllers\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Creator\EventSayaController as CreatorEventSayaController;

// Admin Controller
use App\Http\Controllers\Admin\DashboardController;

// =============================================================
// PUBLIC ROUTES
// =============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.show');
Route::get('/creator', [CreatorController::class, 'index'])->name('creator.index');
Route::get('/creators/{id}', [CreatorController::class, 'show'])->name('creator.show');
Route::get('/help', [HelpController::class, 'index'])->name('help.index');
Route::get('/pricing', fn() => view('guest.biaya'))->name('pricing');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// =============================================================
// MEMBER / USER ROUTES
// =============================================================
Route::middleware(['auth', 'role:user'])->prefix('member')->name('member.')->group(function () {
    Route::get('/my-tickets',        [UserTiketController::class, 'index'])->name('tiket.index');
    Route::get('/my-tickets/{code}', [UserTiketController::class, 'show'])->name('tiket.show');

    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pengaturan', [UserPengaturanController::class, 'index'])->name('pengaturan.index');
});

// =============================================================
// CREATOR ROUTES
// =============================================================
Route::middleware(['auth', 'role:user'])->prefix('creator')->name('creator.')->group(function () {
    Route::get('/dashboard', [CreatorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/events', [CreatorEventSayaController::class, 'index'])->name('eventsaya.index');
    Route::get('/events/{id}/stats', [CreatorEventSayaController::class, 'show'])->name('eventsaya.stats');
});

// =============================================================
// ORDER & PAYMENT ROUTES (MODERN FLOW)
// =============================================================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/creator/buat-event', [CreatorController::class, 'create'])->name('creator.create');
    Route::post('/creator/buat-event', [CreatorController::class, 'store'])->name('creator.store');

    // Alur Pemesanan Tiket
    Route::get('/events/{id}/buy',      [UserOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',              [UserOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/confirm/{id}',  [UserOrderController::class, 'confirm'])->name('orders.confirm');
    
    // Alur Pembayaran & Midtrans
    Route::get('/payment/token/{order}', [UserOrderController::class, 'getSnapToken'])->name('orders.token');    
    Route::get('/orders/success/{id}',   [UserOrderController::class, 'paymentSuccess'])->name('orders.success');

    // Route Tambahan (Opsional sesuai kodingan lama)
    Route::post('/orders/pay',          [UserOrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{id}/payment',  [UserOrderController::class, 'payment'])->name('orders.payment');
    Route::post('/orders/{id}/upload',  [UserOrderController::class, 'uploadProof'])->name('orders.upload');
});

// =============================================================
// ADMIN ROUTES
// =============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';