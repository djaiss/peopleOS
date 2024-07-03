<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\Settings\SettingsProfileController;
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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('', [SettingsController::class, 'index'])->name('index');

        // profile
        Route::get('profile', [SettingsProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [SettingsProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';
