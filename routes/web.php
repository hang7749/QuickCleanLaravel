<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SupabaseLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminProviderController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminListController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [SupabaseLoginController::class, 'login']);
Route::get('/auth/google', [SupabaseLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SupabaseLoginController::class, 'handleGoogleCallback']);

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [SupabaseLoginController::class, 'register']);

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'zh', 'my'])) {
        session(['my_app_locale' => $locale]);
    }
    return redirect()->back();
});

Route::middleware(['auth'])->group(function () {
    
    // Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index'); // profile.index
        Route::put('/update', [ProfileController::class, 'updateUsername'])->name('update'); // profile.update
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password'); // profile.password
    });

    // Booking & Payment System
    Route::controller(BookingController::class)->group(function () {
        // List and View
        Route::get('/my-bookings', 'index')->name('booking.index');
        Route::get('/booking/{id}', 'show')->name('booking.show');
        
        // Actions
        Route::put('/bookings/{id}/cancel', 'cancel')->name('booking.cancel');
        
        // Payment Flow
        Route::post('/payment/initiate', 'proceed')->name('booking.proceed');
        Route::get('/payment', 'showPayment')->name('payment.show');
        Route::post('/payment/process', 'processPayment')->name('payment.process');
    });

});

////////////////////////////////////////////////////////////////////////////////////////////////////////
// Admin Login Routes
Route::get('/admin', function () {
    return view('auth.admin_login'); // We will create this view next
})->name('admin.login');

Route::post('/admin/login', [SupabaseLoginController::class, 'adminLogin']);

//Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('home');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{id}', [AdminBookingController::class, 'update'])->name('bookings.update');

    // Services CRUD
    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [AdminServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    Route::resource('providers', AdminProviderController::class);
    Route::resource('members', AdminMemberController::class)->except(['create', 'store']);

    Route::get('/admins', [AdminListController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminListController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminListController::class, 'store'])->name('admins.store');
});