<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Creator\EventSayaController as CreatorEventSayaController;
use App\Http\Controllers\Guest\BlogController;
use App\Http\Controllers\Guest\CreatorController;
use App\Http\Controllers\Guest\EventController;
use App\Http\Controllers\Guest\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\PengaturanController as UserPengaturanController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\TiketController as UserTiketController;
use Illuminate\Support\Facades\Route;

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

    // Kelola Akses
    Route::get('/kelola-akses', [CreatorKelolaAksesController::class, 'index'])->name('kelolaakses.index');
    Route::get('/kelola-akses/create', [CreatorKelolaAksesController::class, 'create'])->name('kelolaakses.create');
    Route::post('/kelola-akses/create', [CreatorKelolaAksesController::class, 'store'])->name('kelolaakses.store');
    Route::delete('/kelola-akses/{id}', [CreatorKelolaAksesController::class, 'destroy'])->name('kelolaakses.destroy');
    Route::patch('/kelola-akses/{id}/toggle', [CreatorKelolaAksesController::class, 'toggleStatus'])->name('kelolaakses.toggle');

    // Profile
    Route::get('/profile', [CreatorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CreatorProfileController::class, 'update'])->name('profile.update');

    // Rekening
    Route::get('/rekening',              [CreatorRekeningController::class, 'index'])->name('rekening.index');
    Route::get('/rekening/create',       [CreatorRekeningController::class, 'create'])->name('rekening.create');
    Route::post('/rekening',             [CreatorRekeningController::class, 'store'])->name('rekening.store');
    Route::delete('/rekening/{id}',      [CreatorRekeningController::class, 'destroy'])->name('rekening.destroy');
    Route::patch('/rekening/{id}/primary', [CreatorRekeningController::class, 'setPrimary'])->name('rekening.primary');
});

// =============================================================
// ORDER & PAYMENT ROUTES
// =============================================================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/creator/buat-event', [CreatorController::class, 'create'])->name('creator.create');
    Route::post('/creator/buat-event', [CreatorController::class, 'store'])->name('creator.store');

    Route::get('/events/{id}/buy',      [UserOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',              [UserOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/confirm/{id}',  [UserOrderController::class, 'confirm'])->name('orders.confirm');
    Route::get('/payment/token/{order}', [UserOrderController::class, 'getSnapToken'])->name('orders.token');
    Route::get('/orders/success/{id}',   [UserOrderController::class, 'paymentSuccess'])->name('orders.success');
});

// =============================================================
// ADMIN ROUTES
// =============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/event-admin', [App\Http\Controllers\Admin\EventController::class, 'index'])->name('event-admin');
    Route::resource('access', App\Http\Controllers\Admin\AccesController::class);

    Route::resource('access', App\Http\Controllers\Admin\AccesController::class);

    Route::resource('Kategori', App\Http\Controllers\Admin\CategoriesController::class);
    // Manajemen Event
    Route::get('/event-admin', [AdminEventController::class, 'index'])->name('event-admin');
    Route::resource('access', AdminAccessController::class);

    // CRUD TIKET
    // Tetap menggunakan {event} untuk index dan store agar bisa mengambil event_id
    Route::get('event/{event}/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::post('event/{event}/tickets', [AdminTicketController::class, 'store'])->name('tickets.store');

    // Update dan Delete cukup pakai {ticket} karena ID ticket sudah unik
    Route::put('tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::delete('tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{id}/checkout', [App\Http\Controllers\Admin\TicketController::class, 'checkout'])->name('tickets.checkout');
    Route::get('/event/{id}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/event/{id}', [AdminEventController::class, 'update'])->name('events.update');
    Route::resource('access', App\Http\Controllers\Admin\AccesController::class);
});
Route::middleware(['auth', 'role:user'])->prefix('member')->as('member.')->group(function () {
    Route::get('/my-tickets', [TiketController::class, 'index'])->name('tiket.index');
    // Tambahkan ini kalau belum ada:
    Route::get('/my-tickets/{id}', [TiketController::class, 'show'])->name('tiket.show');
});

//bot chat
Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);
Route::get('/botman/chat', [BotManController::class, 'chat'])->name('botman.chat'); // UI frame

require __DIR__ . '/auth.php';
