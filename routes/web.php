<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\Api\SettingsApiAccessController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesController;
use App\Http\Controllers\Settings\Preferences\SettingsPreferencesNameOrderController;
use App\Http\Controllers\Settings\Profile\Settings2FAController;
use App\Http\Controllers\Settings\Profile\SettingsPasswordController;
use App\Http\Controllers\Settings\Profile\SettingsProfileController;
use App\Http\Controllers\Settings\Profile\SettingsRecoveryCodeController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Vaults\Contacts\ContactBackgroundInformationController;
use App\Http\Controllers\Vaults\Contacts\ContactController;
use App\Http\Controllers\Vaults\Contacts\ContactJobInformationController;
use App\Http\Controllers\Vaults\Contacts\ContactNoteController;
use App\Http\Controllers\Vaults\Settings\VaultSettingsController;
use App\Http\Controllers\Vaults\VaultController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware('auth', 'verified', 'account')->group(function (): void {
    Route::get('vaults', [VaultController::class, 'index'])->name('vaults.index');
    Route::get('new', [VaultController::class, 'new'])->name('vaults.new');
    Route::post('new', [VaultController::class, 'store'])->name('vaults.store');

    Route::middleware(['vault'])->prefix('vaults')->group(function (): void {
        Route::get('{vault}', [VaultController::class, 'show'])->name('vaults.show');

        // contacts
        Route::get('{vault}/contacts', [ContactController::class, 'index'])->name('vaults.contacts.index');
        Route::get('{vault}/contacts/new', [ContactController::class, 'new'])->name('vaults.contacts.new');
        Route::post('{vault}/contacts', [ContactController::class, 'store'])->name('vaults.contacts.store');

        Route::middleware(['contact'])->group(function (): void {
            Route::get('{vault}/contacts/{slug}', [ContactController::class, 'show'])->name('vaults.contacts.show');

            // job & background information
            Route::put('{vault}/contacts/{slug}/job-information', [ContactJobInformationController::class, 'update'])->name('vaults.contacts.job-information.update');
            Route::put('{vault}/contacts/{slug}/background-information', [ContactBackgroundInformationController::class, 'update'])->name('vaults.contacts.background-information.update');

            Route::delete('{vault}/contacts/{slug}', [ContactController::class, 'destroy'])->name('vaults.contacts.destroy');
        });

        // settings
        Route::get('{vault}/settings', [VaultSettingsController::class, 'index'])->name('vaults.settings.index');
        Route::delete('{vault}', [VaultController::class, 'destroy'])->name('vaults.destroy');
    });

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('settings')->group(function (): void {
        Route::get('', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('profile', [SettingsProfileController::class, 'update'])->name('settings.profile.update');

        // preferences
        Route::get('preferences', [SettingsPreferencesController::class, 'index'])->name('settings.preferences.index');

        // update name order
        Route::get('preferences/name', [SettingsPreferencesNameOrderController::class, 'index'])->name('settings.preferences.name.index');
        Route::get('preferences/name/edit', [SettingsPreferencesNameOrderController::class, 'edit'])->name('settings.preferences.name.edit');
        Route::put('preferences/name', [SettingsPreferencesNameOrderController::class, 'update'])->name('settings.preferences.name.update');

        // profile
        Route::get('profile', [SettingsProfileController::class, 'index'])->name('settings.profile.index');
        Route::put('password', [SettingsPasswordController::class, 'update'])->name('settings.password.update');

        // 2fa
        Route::get('2fa', [Settings2FAController::class, 'new'])->name('settings.profile.2fa.new');
        Route::get('2fa/details', [Settings2FAController::class, 'show'])->name('settings.profile.2fa.show');
        Route::post('2fa', [Settings2FAController::class, 'store'])->name('settings.profile.2fa.store');
        Route::delete('2fa', [Settings2FAController::class, 'destroy'])->name('settings.profile.2fa.destroy');

        // recovery codes
        Route::get('recovery-codes', [SettingsRecoveryCodeController::class, 'show'])->name('settings.profile.recovery-code.show');

        // api
        Route::get('api', [SettingsApiAccessController::class, 'index'])->name('settings.api.index');
        Route::get('api/new', [SettingsApiAccessController::class, 'new'])->name('settings.api.new');
        Route::post('api', [SettingsApiAccessController::class, 'store'])->name('settings.api.store');
        Route::delete('api/{key}', [SettingsApiAccessController::class, 'destroy'])->name('settings.api.destroy');
    });
});

require __DIR__.'/auth.php';
