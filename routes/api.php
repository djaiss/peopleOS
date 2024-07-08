<?php

use App\Http\Controllers\Api\Settings\MeController;
use App\Http\Controllers\Api\Vaults\VaultController;
use App\Http\Middleware\CheckVault;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [MeController::class, 'show'])->name('me');

    // manage vaults
    Route::get('vaults', [VaultController::class, 'index']);
    Route::post('vaults', [VaultController::class, 'create']);

    Route::middleware(CheckVault::class)->prefix('vaults/{vault}')->group(function () {
        Route::delete('', [VaultController::class, 'destroy']);
    });
});
