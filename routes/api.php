<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// General Integration API for JIT synchronization and other internal/external services
Route::prefix('integrations')->middleware('client.auth')->group(function () {
    Route::post('/users', [\App\Http\Controllers\Api\Integrations\UserSyncController::class, 'sync']);
});
