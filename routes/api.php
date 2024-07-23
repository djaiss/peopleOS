<?php

use App\Http\Controllers\Api\Settings\MeController;
use App\Http\Controllers\Api\Vaults\CompanyController;
use App\Http\Controllers\Api\Vaults\ContactBackgroundInformationController;
use App\Http\Controllers\Api\Vaults\ContactController;
use App\Http\Controllers\Api\Vaults\ContactJobInformationController;
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

        // manage contacts
        Route::get('contacts', [ContactController::class, 'index']);
        Route::post('contacts', [ContactController::class, 'create']);
        Route::middleware(['contact'])->group(function (): void {
            //Route::get('contacts/{slug}', [ContactController::class, 'show']);

            Route::middleware(['is_at_least_editor'])->group(function (): void {
                Route::put('contacts/{slug}/job', [ContactJobInformationController::class, 'update']);
                Route::put('contacts/{slug}/background', [ContactBackgroundInformationController::class, 'update']);
                Route::delete('contacts/{slug}', [ContactController::class, 'destroy']);
            });
        });

        // manage companies
        Route::get('companies', [CompanyController::class, 'index']);
        Route::middleware(['is_at_least_editor'])->group(function (): void {
            Route::post('companies', [CompanyController::class, 'create']);
            Route::put('companies/{company}', [CompanyController::class, 'update']);
            Route::delete('companies/{company}', [CompanyController::class, 'destroy']);
        });
    });
});
