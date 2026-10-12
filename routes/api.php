<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Integrations\PermissionSyncController;
use App\Http\Controllers\Api\Integrations\UserSyncController;
use App\Http\Controllers\Api\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-2fa', [AuthController::class, 'verify2fa']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 2FA Management (100% offline)
    Route::get('/2fa/status', [TwoFactorController::class, 'status']);
    Route::post('/2fa/setup', [TwoFactorController::class, 'setup']);
    Route::post('/2fa/confirm', [TwoFactorController::class, 'confirm']);
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable']);
});

// General Integration API for JIT synchronization and other internal/external services
Route::prefix('integrations')->middleware('client.auth')->group(function () {
    Route::post('/users', [UserSyncController::class, 'sync']);
    Route::post('/permissions', [PermissionSyncController::class, 'sync']);
});
