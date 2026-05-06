<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SupabaseLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
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

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', [SupabaseLoginController::class, 'register']);


//Member area routes
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::post('/logout',          [ProfileController::class, 'logout'])->name('logout');

// Profile routes
Route::get('/profile',          [ProfileController::class, 'index'])->name('profile');
Route::put('/profile/update',   [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // Form action for Name
    Route::put('/profile/update', [ProfileController::class, 'updateName'])->name('profile.update');
    
    // Form action for Password
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


// Booking routes
Route::middleware(['auth'])->group(function () {

    // View all bookings
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Show the page (e.g., /booking/1)
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    // payment
    Route::post('/payment/initiate', [BookingController::class, 'proceed'])->name('booking.proceed');
    Route::get('/payment', [BookingController::class, 'showPayment'])->name('payment.show');
    Route::post('/payment/process', [BookingController::class, 'processPayment'])->name('payment.process');
    
});

// Admin Login Routes
Route::get('/admin', function () {
    return view('auth.admin_login'); // We will create this view next
})->name('admin.login');

Route::post('/admin/login', [SupabaseLoginController::class, 'adminLogin']);

// Protected Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.home');
})->middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class]);