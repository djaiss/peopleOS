<?php

declare(strict_types=1);

use App\Http\Controllers\Administration\AdministrationAccountController;
use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Administration\AdministrationPersonalizationController;
use App\Http\Controllers\Administration\AdministrationSecurityController;
use App\Http\Controllers\Instance\InstanceController;
use App\Http\Controllers\Persons\PersonController;
use App\Http\Controllers\Persons\PersonGiftController;
use App\Http\Controllers\Persons\PersonNoteController;
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

    // persons
    Route::get('persons', [PersonController::class, 'index'])->name('persons.index');
    Route::get('persons/new', [PersonController::class, 'new'])->name('persons.new');
    Route::post('persons', [PersonController::class, 'store'])->name('persons.store');
    Route::middleware(['person'])->group(function (): void {
        Route::get('persons/{slug}', [PersonController::class, 'show'])->name('persons.show');
    });

    // persons notes
    Route::get('persons/notes', [PersonNoteController::class, 'index'])->name('persons.notes.index');

    // persons gifts
    Route::get('persons/gifts', [PersonGiftController::class, 'index'])->name('persons.gifts.index');

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
    Route::get('administration/security', [AdministrationSecurityController::class, 'index'])->name('administration.security.index');

    Route::get('administration/personalization', [AdministrationPersonalizationController::class, 'index'])->name('administration.personalization.index');

    Route::get('administration/account', [AdministrationAccountController::class, 'index'])->name('administration.account.index');
    Route::delete('administration/account', [AdministrationAccountController::class, 'destroy'])->name('administration.account.destroy');

    Route::middleware(['instance.admin'])->group(function (): void {
        Route::get('instance', [InstanceController::class, 'index'])->name('instance.index');
        Route::get('instance/{instance}', [InstanceController::class, 'show'])->name('instance.show');
    });
});

require __DIR__.'/auth.php';
