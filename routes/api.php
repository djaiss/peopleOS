<?php

use App\Http\Controllers\Api\Settings\GenderController;
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

    // manage genders
    Route::get('genders', [GenderController::class, 'index']);
    Route::post('genders', [GenderController::class, 'create']);
    Route::put('genders/{gender}', [GenderController::class, 'update']);
    Route::delete('genders/{gender}', [GenderController::class, 'destroy']);

    // manage vaults
    Route::get('vaults', [VaultController::class, 'index']);
    Route::post('vaults', [VaultController::class, 'create']);

    Route::middleware(CheckVault::class)->group(function () {
        Route::put('vaults/{vault}', [VaultController::class, 'update']);
        Route::delete('vaults/{vault}', [VaultController::class, 'destroy']);

        // manage contacts
        Route::get('vaults/{vault}/contacts', [ContactController::class, 'index']);
        Route::post('vaults/{vault}/contacts', [ContactController::class, 'create']);
        Route::middleware(['contact'])->group(function (): void {
            //Route::get('contacts/{slug}', [ContactController::class, 'show']);

            Route::middleware(['is_at_least_editor'])->group(function (): void {
                Route::put('vaults/{vault}/contacts/{slug}/job', [ContactJobInformationController::class, 'update']);
                Route::put('vaults/{vault}/contacts/{slug}/background', [ContactBackgroundInformationController::class, 'update']);
                Route::delete('vaults/{vault}/contacts/{slug}', [ContactController::class, 'destroy']);
            });
        });

        // manage companies
        Route::get('vaults/{vault}/companies', [CompanyController::class, 'index']);
        Route::middleware(['is_at_least_editor'])->group(function (): void {
            Route::post('vaults/{vault}/companies', [CompanyController::class, 'create']);
            Route::put('vaults/{vault}/companies/{company}', [CompanyController::class, 'update']);
            Route::delete('vaults/{vault}/companies/{company}', [CompanyController::class, 'destroy']);
        });
    });
});
