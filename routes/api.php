<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationOfficeController;
use App\Http\Controllers\Api\Administration\AdministrationUserController;
use App\Http\Controllers\Api\Administration\GenderController;
use App\Http\Controllers\Api\Administration\MaritalStatusController;
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

    // users
    Route::post('administration/users', [AdministrationUserController::class, 'store'])->name('users.store');
    Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update'])->name('users.invite');

    // genders
    Route::get('administration/genders', [GenderController::class, 'index'])->name('administration.genders.index');
    Route::post('administration/genders', [GenderController::class, 'store'])->name('administration.genders.store');
    Route::put('administration/genders/{gender}', [GenderController::class, 'update'])->name('administration.genders.update');
    Route::delete('administration/genders/{gender}', [GenderController::class, 'destroy'])->name('administration.genders.destroy');

    // marital statuses
    Route::get('administration/marital-statuses', [MaritalStatusController::class, 'index'])->name('administration.marital-statuses.index');
    Route::post('administration/marital-statuses', [MaritalStatusController::class, 'store'])->name('administration.marital-statuses.store');
    Route::put('administration/marital-statuses/{maritalStatus}', [MaritalStatusController::class, 'update'])->name('administration.marital-statuses.update');
    Route::delete('administration/marital-statuses/{maritalStatus}', [MaritalStatusController::class, 'destroy'])->name('administration.marital-statuses.destroy');
});
