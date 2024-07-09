<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\Api\SettingsApiAccessController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesNameOrderController;
use App\Http\Controllers\Settings\Profile\SettingsPasswordController;
use App\Http\Controllers\Settings\Profile\SettingsProfileController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Vaults\Contacts\ContactController;
use App\Http\Controllers\Vaults\Settings\VaultSettingsController;
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

        // contacts
        Route::get('{vault}/contacts', [ContactController::class, 'index'])->name('vaults.contacts.index');
        Route::get('{vault}/new', [ContactController::class, 'new'])->name('vaults.contacts.new');
        Route::get('{vault}/contacts/{contact}', [ContactController::class, 'index'])->name('contacts.show');

        // settings
        Route::get('{vault}/settings', [VaultSettingsController::class, 'index'])->name('vaults.settings.index');
        Route::delete('{vault}', [VaultController::class, 'destroy'])->name('vaults.destroy');
    });

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('settings')->group(function () {
        Route::get('', [SettingsController::class, 'index'])->name('settings.index');

        // preferences
        Route::get('preferences', [SettingsPreferencesController::class, 'index'])->name('settings.preferences.index');

        // update name order
        Route::get('preferences/name', [SettingsPreferencesNameOrderController::class, 'index'])->name('settings.preferences.name.index');
        Route::get('preferences/name/edit', [SettingsPreferencesNameOrderController::class, 'edit'])->name('settings.preferences.name.edit');
        Route::put('preferences/name', [SettingsPreferencesNameOrderController::class, 'update'])->name('settings.preferences.name.update');

        // profile
        Route::get('profile', [SettingsProfileController::class, 'index'])->name('settings.profile.index');
        Route::put('profile', [SettingsProfileController::class, 'update'])->name('settings.profile.update');
        Route::put('password', [SettingsPasswordController::class, 'update'])->name('settings.password.update');

        // api
        Route::get('api', [SettingsApiAccessController::class, 'index'])->name('settings.api.index');
        Route::get('api/new', [SettingsApiAccessController::class, 'new'])->name('settings.api.new');
        Route::post('api', [SettingsApiAccessController::class, 'store'])->name('settings.api.store');
        Route::delete('api/{key}', [SettingsApiAccessController::class, 'destroy'])->name('settings.api.destroy');
    });
});

require __DIR__.'/auth.php';
