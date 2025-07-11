<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\RoomTypeController;
use App\Http\Controllers\API\HotelAmenityController;
use App\Http\Controllers\API\RoomImageController;
use App\Http\Controllers\API\PromotionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HotelController::class, 'index'])->name('home');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // User routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Admin routes (restricted to super_admin or hotel_manager)
    Route::middleware('role:super_admin|hotel_manager')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/hotels', [HotelController::class, 'index'])->name('admin.hotels.index');
            Route::get('/hotels/create', [HotelController::class, 'create'])->name('admin.hotels.create');
            Route::post('/hotels', [HotelController::class, 'store'])->name('admin.hotels.store');
            Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('admin.hotels.edit');
            Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('admin.hotels.update');
            Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('admin.hotels.destroy');

            Route::resource('rooms', RoomController::class)->except(['show']);
            Route::resource('room-types', RoomTypeController::class);
            Route::resource('hotel-amenities', HotelAmenityController::class);
            Route::resource('room-images', RoomImageController::class);
            Route::resource('promotions', PromotionController::class);
            Route::resource('users', AdminController::class);
        });
    });
});