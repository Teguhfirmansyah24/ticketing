<?php

use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
// Pastikan nama file di folder app/Http/Controllers/Admin adalah EventController.php
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;

// User/Member Controllers
use App\Http\Controllers\User\TiketController as UserTiketController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\PengaturanController as UserPengaturanController;

// Creator Controllers
use App\Http\Controllers\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Creator\EventSayaController as CreatorEventSayaController;

// Guest Controllers
use App\Http\Controllers\Guest\BlogController;
use App\Http\Controllers\Guest\EventController;
use App\Http\Controllers\Guest\HelpController;
use App\Http\Controllers\Guest\CreatorController;

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
    Route::get('/my-tickets/{id}',   [UserTiketController::class, 'show'])->name('tiket.show');

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

    // Buat Event
    Route::get('/buat-event', [CreatorController::class, 'create'])->name('create');
    Route::post('/buat-event', [CreatorController::class, 'store'])->name('store');
});

// =============================================================
// ORDER & PAYMENT ROUTES
// =============================================================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/events/{id}/buy',       [UserOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',               [UserOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/confirm/{id}',   [UserOrderController::class, 'confirm'])->name('orders.confirm');
    Route::get('/payment/token/{order}', [UserOrderController::class, 'getSnapToken'])->name('orders.token');
    Route::get('/orders/success/{id}',   [UserOrderController::class, 'paymentSuccess'])->name('orders.success');
});

// =============================================================
// ADMIN ROUTES
// =============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Event & Tiket Admin
    Route::get('/event-admin', [AdminEventController::class, 'index'])->name('event-admin');
    Route::get('/event/{id}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/event/{id}', [AdminEventController::class, 'update'])->name('events.update');

    // CRUD TIKET ADMIN
    Route::get('event/{event}/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::post('event/{event}/tickets', [AdminTicketController::class, 'store'])->name('tickets.store');
    Route::put('tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::delete('tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{id}/checkout', [AdminTicketController::class, 'checkout'])->name('tickets.checkout');

    // Resources (Pastikan nama class sesuai dengan file di folder Admin)
    Route::resource('access', App\Http\Controllers\Admin\AccessController::class);
    Route::resource('kategori', App\Http\Controllers\Admin\CategoriesController::class);
});

// =============================================================
// BOTMAN & AUTH
// =============================================================
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/botman/chat', [BotManController::class, 'chat'])->name('botman.chat');

require __DIR__ . '/auth.php';