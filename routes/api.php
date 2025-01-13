<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationOfficeController;
use App\Http\Controllers\Api\Administration\AdministrationUserController;
use App\Http\Controllers\Api\Administration\MeController;
use App\Http\Controllers\Api\Teams\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {

    // logged user
    Route::get('me', [MeController::class, 'show'])->name('me');
    Route::put('me', [MeController::class, 'update'])->name('me.update');

    // teams
    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::middleware(['team.api'])->group(function (): void {
        Route::put('teams/{team}', [TeamController::class, 'update'])->name('teams.update');
        Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    });

    // account information
    Route::middleware(['administrator'])->group(function (): void {

        // offices
        Route::post('administration/offices', [AdministrationOfficeController::class, 'store'])->name('offices.store');
        Route::put('administration/offices/{office}', [AdministrationOfficeController::class, 'update'])->name('offices.update');
        Route::delete('administration/offices/{office}', [AdministrationOfficeController::class, 'destroy'])->name('offices.destroy');
        Route::get('administration/offices', [AdministrationOfficeController::class, 'index'])->name('offices.index');
    });

    Route::middleware(['administrator_or_hr'])->group(function (): void {
        // users
        Route::post('administration/users', [AdministrationUserController::class, 'store'])->name('users.store');
        Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update'])->name('users.invite');
    });
});
