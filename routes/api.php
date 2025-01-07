<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AccountController;
use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationUserController;
use App\Http\Controllers\Api\Administration\MeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {

    // logged user
    Route::get('me', [MeController::class, 'show'])->name('me');
    Route::put('me', [MeController::class, 'update'])->name('me.update');

    // account information
    Route::get('account', [AccountController::class, 'show'])->name('account');
    Route::middleware(['administrator'])->group(function (): void {
        Route::put('account', [AccountController::class, 'update'])->name('account.update');
    });

    Route::middleware(['administrator_or_hr'])->group(function (): void {
        Route::post('administration/users', [AdministrationUserController::class, 'store'])->name('users.store');
        Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update'])->name('users.invite');
    });
});
