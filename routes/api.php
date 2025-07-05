<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\RoomTypeController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\HotelAmenityController;
use App\Http\Controllers\API\RoomImageController;
use App\Http\Controllers\API\PromotionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/csrf-token', [AuthController::class, 'csrfToken']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // User routes
    Route::apiResource('users', UserController::class)->except(['store']);

    // Admin routes (protected by role)
    Route::middleware('role:super_admin|hotel_manager')->apiResource('admins', AdminController::class);

    // Hotel routes
    Route::apiResource('hotels', HotelController::class);

    // Room Type routes
    Route::apiResource('room-types', RoomTypeController::class);

    // Room routes
    Route::apiResource('rooms', RoomController::class);

    // Reservation routes
    Route::apiResource('reservations', ReservationController::class);

    // Payment routes
    Route::apiResource('payments', PaymentController::class);

    // Review routes
    Route::apiResource('reviews', ReviewController::class);

    // Hotel Amenity routes
    Route::apiResource('hotel-amenities', HotelAmenityController::class);

    // Room Image routes
    Route::apiResource('room-images', RoomImageController::class);

    // Promotion routes
    Route::apiResource('promotions', PromotionController::class);
});