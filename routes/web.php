<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\Profile\SettingsPasswordController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesNameOrderController;
use App\Http\Controllers\Settings\Profile\SettingsProfileController;
use App\Http\Controllers\Vaults\VaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('', [VaultController::class, 'index'])->name('vaults.index');
    Route::get('new', [VaultController::class, 'new'])->name('vaults.new');
    Route::post('new', [VaultController::class, 'store'])->name('vaults.store');

    Route::middleware(['vault'])->prefix('vaults')->group(function (): void {
        Route::get('{vault}', [VaultController::class, 'show'])->name('vaults.show');

        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    });

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('settings')->group(function () {
        Route::get('', [SettingsController::class, 'index'])->name('settings.index');

        // preferences
        Route::get('preferences', [SettingsPreferencesController::class, 'index'])->name('settings.preferences.index');

        // update name order
        Route::get('preferences/name', [SettingsPreferencesNameOrderController::class, 'index'])->name('settings.preferences.name.index');
        Route::get('preferences/name/edit', [SettingsPreferencesNameOrderController::class, 'edit'])->name('settings.preferences.name.edit');
        Route::post('preferences/name', [SettingsPreferencesNameOrderController::class, 'store'])->name('settings.preferences.name.store');

        // profile
        Route::get('profile', [SettingsProfileController::class, 'index'])->name('settings.profile.index');
        Route::put('profile', [SettingsProfileController::class, 'update'])->name('settings.profile.update');
        Route::put('password', [SettingsPasswordController::class, 'update'])->name('settings.password.update');
    });
});

require __DIR__.'/auth.php';
