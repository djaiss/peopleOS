<?php

declare(strict_types=1);

use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Administration\AdministrationOfficeController;
use App\Http\Controllers\Administration\AdministrationPersonalizationController;
use App\Http\Controllers\Administration\AdministrationSecurityController;
use App\Http\Controllers\Administration\AdministrationUserController;
use App\Http\Controllers\UpgradeAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invitations/{user}/accept', [AdministrationController::class, 'accept'])->name('invitations.accept');

Route::middleware(['auth:sanctum', 'verified', 'subscription'])->group(function (): void {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // upgrade
    Route::get('upgrade', [UpgradeAccountController::class, 'index'])->name('upgrade.index');

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
    Route::get('administration/security', [AdministrationSecurityController::class, 'index'])->name('administration.security.index');

    Route::get('administration/personalization', [AdministrationPersonalizationController::class, 'index'])->name('administration.personalization.index');

    Route::get('administration/offices', [AdministrationOfficeController::class, 'index'])->name('administration.offices.index');
    Route::get('administration/users', [AdministrationUserController::class, 'index'])->name('administration.users.index');
});

require __DIR__.'/auth.php';
