<?php

use App\Http\Controllers\Api\Settings\EthnicityController;
use App\Http\Controllers\Api\Settings\GenderController;
use App\Http\Controllers\Api\Settings\MeController;
use App\Http\Controllers\Api\Vaults\CompanyController;
use App\Http\Controllers\Api\Vaults\ContactBackgroundInformationController;
use App\Http\Controllers\Api\Vaults\ContactController;
use App\Http\Controllers\Api\Vaults\ContactJobInformationController;
use App\Http\Controllers\Api\Vaults\ContactPhoneNumberController;
use App\Http\Controllers\Api\Vaults\VaultController;
use App\Http\Middleware\CheckVault;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('me', [MeController::class, 'show'])->name('me');

    // manage genders
    Route::get('genders', [GenderController::class, 'index']);
    Route::get('genders/{gender}', [GenderController::class, 'show']);
    Route::post('genders', [GenderController::class, 'create']);
    Route::put('genders/{gender}', [GenderController::class, 'update']);
    Route::delete('genders/{gender}', [GenderController::class, 'destroy']);

    // manage ethnicities
    Route::get('ethnicities', [EthnicityController::class, 'index']);
    Route::get('ethnicities/{ethnicity}', [EthnicityController::class, 'show']);
    Route::post('ethnicities', [EthnicityController::class, 'create']);
    Route::put('ethnicities/{ethnicity}', [EthnicityController::class, 'update']);
    Route::delete('ethnicities/{ethnicity}', [EthnicityController::class, 'destroy']);

    // manage vaults
    Route::get('vaults', [VaultController::class, 'index']);
    Route::post('vaults', [VaultController::class, 'create']);

    Route::middleware(CheckVault::class)->group(function (): void {
        Route::get('vaults/{vault}', [VaultController::class, 'show']);
        Route::put('vaults/{vault}', [VaultController::class, 'update']);
        Route::delete('vaults/{vault}', [VaultController::class, 'destroy']);

        // manage contacts
        Route::get('vaults/{vault}/contacts', [ContactController::class, 'index']);
        Route::post('vaults/{vault}/contacts', [ContactController::class, 'create']);
        Route::middleware(['api_contact'])->group(function (): void {
            Route::get('vaults/{vault}/contacts/{contact}', [ContactController::class, 'show']);

            Route::middleware(['is_at_least_editor'])->group(function (): void {
                Route::put('vaults/{vault}/contacts/{contact}/job', [ContactJobInformationController::class, 'update']);
                Route::put('vaults/{vault}/contacts/{contact}/background', [ContactBackgroundInformationController::class, 'update']);
                Route::delete('vaults/{vault}/contacts/{contact}', [ContactController::class, 'destroy']);

                // manage contact phone numbers
                Route::get('vaults/{vault}/contacts/{contact}/phone-numbers', [ContactPhoneNumberController::class, 'index']);
                Route::post('vaults/{vault}/contacts/{contact}/phone-numbers', [ContactPhoneNumberController::class, 'create']);
                Route::put('vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}', [ContactPhoneNumberController::class, 'update']);
                Route::delete('vaults/{vault}/contacts/{contact}/phone-numbers/{contactPhoneNumber}', [ContactPhoneNumberController::class, 'destroy']);
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
