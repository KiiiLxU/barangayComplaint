<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ComplaintController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BrgyOfficialController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Version 1
Route::prefix('v1')->group(function () {

    // Authentication routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User routes
        Route::apiResource('users', UserController::class);

        // Complaint routes
        Route::apiResource('complaints', ComplaintController::class);

        // Brgy Official routes
        Route::apiResource('officials', \App\Http\Controllers\Api\V1\BrgyOfficialController::class);
    });
});
