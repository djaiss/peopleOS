<?php

declare(strict_types=1);

use App\Http\Controllers\Administration\AdministrationAccountController;
use App\Http\Controllers\Administration\AdministrationAvatarController;
use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Administration\AdministrationGenderController;
use App\Http\Controllers\Administration\AdministrationLogsController;
use App\Http\Controllers\Administration\AdministrationPersonalizationController;
use App\Http\Controllers\Administration\AdministrationPruneAccountController;
use App\Http\Controllers\Administration\AdministrationSecurityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Instance\InstanceController;
use App\Http\Controllers\Instance\InstanceDestroyAccountController;
use App\Http\Controllers\Instance\InstanceFreeAccountController;
use App\Http\Controllers\Marketing\MarketingController as MarketingMarketingController;
use App\Http\Controllers\Persons\HowWeMetController;
use App\Http\Controllers\Persons\PersonController;
use App\Http\Controllers\Persons\PersonFamilyController;
use App\Http\Controllers\Persons\PersonGiftController;
use App\Http\Controllers\Persons\PersonNoteController;
use App\Http\Controllers\Persons\PersonReminderController;
use App\Http\Controllers\Persons\PersonSearchController;
use App\Http\Controllers\Persons\PersonSendTestReminderController;
use App\Http\Controllers\Persons\PersonSettingsController;
use App\Http\Controllers\Persons\PersonWorkController;
use App\Http\Controllers\UpgradeAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketingMarketingController::class, 'index'])->name('marketing.index');

Route::get('/invitations/{user}/accept', [AdministrationController::class, 'accept'])->name('invitations.accept');

Route::middleware(['auth:sanctum', 'verified'])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // upgrade
    Route::get('upgrade', [UpgradeAccountController::class, 'index'])->name('upgrade.index');

    Route::middleware(['subscription'])->group(function (): void {
        // persons
        Route::get('persons', [PersonController::class, 'index'])->name('persons.index');
        Route::get('persons/new', [PersonController::class, 'new'])->name('persons.new');
        Route::post('persons', [PersonController::class, 'store'])->name('persons.store');
        Route::post('persons/search', [PersonSearchController::class, 'store'])->name('persons.search');

        Route::middleware(['person'])->group(function (): void {
            Route::get('persons/{slug}', [PersonController::class, 'show'])->name('persons.show');
            Route::get('persons/{slug}/how-we-met', [HowWeMetController::class, 'edit'])->name('persons.how-we-met.edit');
            Route::get('persons/{slug}/how-we-met/toggle', [HowWeMetController::class, 'post'])->name('persons.how-we-met.post');
            Route::put('persons/{slug}/how-we-met', [HowWeMetController::class, 'update'])->name('persons.how-we-met.update');

            // person settings
            Route::get('persons/{slug}/settings', [PersonSettingsController::class, 'index'])->name('persons.settings.index');
            Route::put('persons/{slug}/settings', [PersonSettingsController::class, 'update'])->name('persons.settings.update');

            Route::delete('persons/{slug}', [PersonSettingsController::class, 'destroy'])->name('persons.settings.destroy');

            // reminders
            Route::get('persons/{slug}/reminders', [PersonReminderController::class, 'index'])->name('persons.reminders.index');
            Route::post('persons/{slug}/reminders/{specialDate}/test', [PersonSendTestReminderController::class, 'store'])->name('persons.reminders.test');

            // persons notes
            Route::get('persons/{slug}/notes', [PersonNoteController::class, 'index'])->name('persons.notes.index');
            Route::post('persons/{slug}/notes', [PersonNoteController::class, 'store'])->name('persons.notes.store');
            Route::middleware(['note'])->group(function (): void {
                Route::get('persons/{slug}/notes/{note}/edit', [PersonNoteController::class, 'edit'])->name('persons.notes.edit');
                Route::put('persons/{slug}/notes/{note}', [PersonNoteController::class, 'update'])->name('persons.notes.update');
                Route::delete('persons/{slug}/notes/{note}', [PersonNoteController::class, 'destroy'])->name('persons.notes.destroy');
            });

            // work and passions
            Route::get('persons/{slug}/work', [PersonWorkController::class, 'index'])->name('persons.work.index');
            Route::get('persons/{slug}/work/new', [PersonWorkController::class, 'new'])->name('persons.work.new');
            Route::post('persons/{slug}/work', [PersonWorkController::class, 'store'])->name('persons.work.store');
            Route::get('persons/{slug}/work/{entry}/edit', [PersonWorkController::class, 'edit'])->name('persons.work.edit');
            Route::put('persons/{slug}/work/{entry}', [PersonWorkController::class, 'update'])->name('persons.work.update');
            Route::delete('persons/{slug}/work/{entry}', [PersonWorkController::class, 'destroy'])->name('persons.work.destroy');

            // family
            Route::get('persons/{slug}/family', [PersonFamilyController::class, 'index'])->name('persons.family.index');
        });

        // persons gifts
        Route::get('persons/gifts', [PersonGiftController::class, 'index'])->name('persons.gifts.index');
    });

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
    Route::put('administration/avatar', [AdministrationAvatarController::class, 'update'])->name('administration.avatar.update');
    Route::get('administration/logs', [AdministrationLogsController::class, 'index'])->name('administration.logs.index');

    // security
    Route::get('administration/security', [AdministrationSecurityController::class, 'index'])->name('administration.security.index');
    Route::get('administration/security/new', [AdministrationSecurityController::class, 'new'])->name('administration.security.new');
    Route::post('administration/security', [AdministrationSecurityController::class, 'store'])->name('administration.security.store');
    Route::delete('administration/security/{apiKeyId}', [AdministrationSecurityController::class, 'destroy'])->name('administration.security.destroy');

    // personalization
    Route::get('administration/personalization', [AdministrationPersonalizationController::class, 'index'])->name('administration.personalization.index');

    // genders
    Route::get('administration/personalization/genders/new', [AdministrationGenderController::class, 'new'])->name('administration.personalization.genders.new');
    Route::post('administration/personalization/genders', [AdministrationGenderController::class, 'store'])->name('administration.personalization.genders.store');
    Route::get('administration/personalization/genders/{gender}/edit', [AdministrationGenderController::class, 'edit'])->name('administration.personalization.genders.edit');
    Route::put('administration/personalization/genders/{gender}', [AdministrationGenderController::class, 'update'])->name('administration.personalization.genders.update');
    Route::delete('administration/personalization/genders/{gender}', [AdministrationGenderController::class, 'destroy'])->name('administration.personalization.genders.destroy');

    // account
    Route::get('administration/account', [AdministrationAccountController::class, 'index'])->name('administration.account.index');
    Route::put('administration/prune', [AdministrationPruneAccountController::class, 'update'])->name('administration.account.prune');
    Route::delete('administration/account', [AdministrationAccountController::class, 'destroy'])->name('administration.account.destroy');

    Route::middleware(['instance.admin'])->group(function (): void {
        Route::get('instance', [InstanceController::class, 'index'])->name('instance.index');
        Route::get('instance/accounts/{account}', [InstanceController::class, 'show'])->name('instance.show');
        Route::delete('instance/accounts/{account}', [InstanceDestroyAccountController::class, 'destroy'])->name('instance.destroy');

        Route::put('instance/accounts/{account}/free', [InstanceFreeAccountController::class, 'update'])->name('instance.accounts.free');
    });
});

require __DIR__.'/auth.php';
