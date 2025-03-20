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
use App\Http\Controllers\Administration\AdministrationTaskCategoryController;
use App\Http\Controllers\Administration\AdministrationTimezoneController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Instance\InstanceController;
use App\Http\Controllers\Instance\InstanceDestroyAccountController;
use App\Http\Controllers\Instance\InstanceFreeAccountController;
use App\Http\Controllers\Marketing\MarketingCompanyController;
use App\Http\Controllers\Marketing\MarketingController;
use App\Http\Controllers\Marketing\MarketingDocsController;
use App\Http\Controllers\Marketing\MarketingHandbookController;
use App\Http\Controllers\Marketing\MarketingPricingController;
use App\Http\Controllers\Marketing\MarketingWhyController;
use App\Http\Controllers\Persons\PersonController;
use App\Http\Controllers\Persons\PersonEncounterController;
use App\Http\Controllers\Persons\PersonEncounterToggleController;
use App\Http\Controllers\Persons\PersonFamilyController;
use App\Http\Controllers\Persons\PersonGiftController;
use App\Http\Controllers\Persons\PersonGiftTabController;
use App\Http\Controllers\Persons\PersonHowWeMetController;
use App\Http\Controllers\Persons\PersonInformationController;
use App\Http\Controllers\Persons\PersonNoteController;
use App\Http\Controllers\Persons\PersonReminderController;
use App\Http\Controllers\Persons\PersonSearchController;
use App\Http\Controllers\Persons\PersonSendTestReminderController;
use App\Http\Controllers\Persons\PersonSettingsAvatarController;
use App\Http\Controllers\Persons\PersonSettingsController;
use App\Http\Controllers\Persons\PersonWorkController;
use App\Http\Controllers\UpgradeAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['marketing'])->group(
    function (): void {
        Route::get('/', [MarketingController::class, 'index'])->name('marketing.index');
        Route::get('/about', [MarketingController::class, 'index'])->name('marketing.about.index');
        Route::get('/why', [MarketingWhyController::class, 'index'])->name('marketing.why.index');
        Route::get('/pricing', [MarketingPricingController::class, 'index'])->name('marketing.pricing.index');
        Route::get('/company', [MarketingCompanyController::class, 'index'])->name('marketing.company.index');
        Route::get('/company/handbook', [MarketingHandbookController::class, 'index'])->name('marketing.company.handbook.index');
        Route::get('/company/handbook/project', [MarketingHandbookController::class, 'project'])->name('marketing.company.handbook.project');
        Route::get('/company/handbook/principles', [MarketingHandbookController::class, 'principles'])->name('marketing.company.handbook.principles');
        Route::get('/company/handbook/shipping', [MarketingHandbookController::class, 'shipping'])->name('marketing.company.handbook.shipping');
        Route::get('/company/handbook/money', [MarketingHandbookController::class, 'money'])->name('marketing.company.handbook.money');
        Route::get('/company/handbook/why-open-source', [MarketingHandbookController::class, 'why'])->name('marketing.company.handbook.why-open-source');
        Route::get('/company/handbook/where-am-I-going-with-this', [MarketingHandbookController::class, 'where'])->name('marketing.company.handbook.where');
        Route::get('/company/handbook/marketing', [MarketingHandbookController::class, 'marketing'])->name('marketing.company.handbook.marketing');

        Route::get('/docs', [MarketingDocsController::class, 'index'])->name('marketing.docs.index');
        Route::get('/docs/api/introduction', [MarketingDocsController::class, 'introduction'])->name('marketing.docs.api.introduction');
        Route::get('/docs/api/authentication', [MarketingDocsController::class, 'authentication'])->name('marketing.docs.api.authentication');
        Route::get('/docs/api/errors', [MarketingDocsController::class, 'errors'])->name('marketing.docs.api.errors');
        Route::get('/docs/api/profile', [MarketingDocsController::class, 'profile'])->name('marketing.docs.api.profile');
        Route::get('/docs/api/logs', [MarketingDocsController::class, 'logs'])->name('marketing.docs.api.logs');
        Route::get('/docs/api/api-management', [MarketingDocsController::class, 'apiManagement'])->name('marketing.docs.api.api-management');
        Route::get('/docs/api/genders', [MarketingDocsController::class, 'genders'])->name('marketing.docs.api.genders');
        Route::get('/docs/api/task-categories', [MarketingDocsController::class, 'taskCategories'])->name('marketing.docs.api.task-categories');
        Route::get('/docs/api/gifts', [MarketingDocsController::class, 'gifts'])->name('marketing.docs.api.gifts');
    }
);

Route::get('/invitations/{user}/accept', [AdministrationController::class, 'accept'])->name('invitations.accept');

Route::middleware(['auth:sanctum', 'verified'])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // upgrade
    Route::get('upgrade', [UpgradeAccountController::class, 'index'])->name('upgrade.index');

    Route::middleware(['subscription'])->group(function (): void {
        // persons
        Route::get('persons', [PersonController::class, 'index'])->name('persons.index');
        Route::get('persons/new', [PersonController::class, 'new'])->name('persons.new');
        Route::post('persons', [PersonController::class, 'create'])->name('persons.create');
        Route::post('persons/search', [PersonSearchController::class, 'create'])->name('persons.search');

        Route::middleware(['person'])->group(function (): void {
            Route::get('persons/{slug}', [PersonController::class, 'show'])->name('persons.show');
            Route::get('persons/{slug}/how-we-met', [PersonHowWeMetController::class, 'edit'])->name('persons.how-we-met.edit');
            Route::get('persons/{slug}/how-we-met/toggle', [PersonHowWeMetController::class, 'create'])->name('persons.how-we-met.create');
            Route::put('persons/{slug}/how-we-met', [PersonHowWeMetController::class, 'update'])->name('persons.how-we-met.update');

            Route::get('persons/{slug}/information/edit', [PersonInformationController::class, 'edit'])->name('persons.information.edit');
            Route::put('persons/{slug}/information', [PersonInformationController::class, 'update'])->name('persons.information.update');

            Route::get('persons/{slug}/encounters/new', [PersonEncounterController::class, 'new'])->name('persons.encounters.new');
            Route::post('persons/{slug}/encounters', [PersonEncounterController::class, 'create'])->name('persons.encounters.create');
            Route::get('persons/{slug}/encounters/toggle', [PersonEncounterToggleController::class, 'create'])->name('persons.encounters.toggle');
            Route::get('persons/{slug}/encounters/{encounter}/edit', [PersonEncounterController::class, 'edit'])->name('persons.encounters.edit');
            Route::put('persons/{slug}/encounters/{encounter}', [PersonEncounterController::class, 'update'])->name('persons.encounters.update');
            Route::delete('persons/{slug}/encounters/{encounter}', [PersonEncounterController::class, 'destroy'])->name('persons.encounters.destroy');

            // person settings
            Route::get('persons/{slug}/settings', [PersonSettingsController::class, 'index'])->name('persons.settings.index');
            Route::put('persons/{slug}/settings', [PersonSettingsController::class, 'update'])->name('persons.settings.update');
            Route::put('persons/{slug}/settings/avatar', [PersonSettingsAvatarController::class, 'update'])->name('persons.settings.avatar.update');
            Route::delete('persons/{slug}', [PersonSettingsController::class, 'destroy'])->name('persons.settings.destroy');

            // reminders
            Route::get('persons/{slug}/reminders', [PersonReminderController::class, 'index'])->name('persons.reminders.index');
            Route::post('persons/{slug}/reminders/{specialDate}/test', [PersonSendTestReminderController::class, 'create'])->name('persons.reminders.test');

            // persons notes
            Route::get('persons/{slug}/notes', [PersonNoteController::class, 'index'])->name('persons.notes.index');
            Route::post('persons/{slug}/notes', [PersonNoteController::class, 'create'])->name('persons.notes.create');
            Route::middleware(['note'])->group(function (): void {
                Route::get('persons/{slug}/notes/{note}/edit', [PersonNoteController::class, 'edit'])->name('persons.notes.edit');
                Route::put('persons/{slug}/notes/{note}', [PersonNoteController::class, 'update'])->name('persons.notes.update');
                Route::delete('persons/{slug}/notes/{note}', [PersonNoteController::class, 'destroy'])->name('persons.notes.destroy');
            });

            // work and passions
            Route::get('persons/{slug}/work', [PersonWorkController::class, 'index'])->name('persons.work.index');
            Route::get('persons/{slug}/work/new', [PersonWorkController::class, 'new'])->name('persons.work.new');
            Route::post('persons/{slug}/work', [PersonWorkController::class, 'create'])->name('persons.work.create');
            Route::get('persons/{slug}/work/{entry}/edit', [PersonWorkController::class, 'edit'])->name('persons.work.edit');
            Route::put('persons/{slug}/work/{entry}', [PersonWorkController::class, 'update'])->name('persons.work.update');
            Route::delete('persons/{slug}/work/{entry}', [PersonWorkController::class, 'destroy'])->name('persons.work.destroy');

            // family
            Route::get('persons/{slug}/family', [PersonFamilyController::class, 'index'])->name('persons.family.index');

            // gifts
            Route::get('persons/{slug}/gifts', [PersonGiftController::class, 'index'])->name('persons.gifts.index');
            Route::get('persons/{slug}/gifts/new', [PersonGiftController::class, 'new'])->name('persons.gifts.new');
            Route::post('persons/{slug}/gifts', [PersonGiftController::class, 'create'])->name('persons.gifts.create');
            Route::get('persons/{slug}/gifts/tab/{status}', [PersonGiftTabController::class, 'update'])->name('persons.gifts.tab.update');
            Route::middleware(['gift'])->group(function (): void {
                Route::get('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'edit'])->name('persons.gifts.edit');
                Route::put('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'update'])->name('persons.gifts.update');
                Route::delete('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'destroy'])->name('persons.gifts.destroy');
            });
        });
    });

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
    Route::put('administration/timezone', [AdministrationTimezoneController::class, 'update'])->name('administration.timezone.update');
    Route::put('administration/avatar', [AdministrationAvatarController::class, 'update'])->name('administration.avatar.update');
    Route::get('administration/logs', [AdministrationLogsController::class, 'index'])->name('administration.logs.index');

    // security
    Route::get('administration/security', [AdministrationSecurityController::class, 'index'])->name('administration.security.index');
    Route::get('administration/security/new', [AdministrationSecurityController::class, 'new'])->name('administration.security.new');
    Route::post('administration/security', [AdministrationSecurityController::class, 'create'])->name('administration.security.create');
    Route::delete('administration/security/{apiKeyId}', [AdministrationSecurityController::class, 'destroy'])->name('administration.security.destroy');

    // personalization
    Route::get('administration/personalization', [AdministrationPersonalizationController::class, 'index'])->name('administration.personalization.index');

    // genders
    Route::get('administration/personalization/genders/new', [AdministrationGenderController::class, 'new'])->name('administration.personalization.genders.new');
    Route::post('administration/personalization/genders', [AdministrationGenderController::class, 'create'])->name('administration.personalization.genders.create');
    Route::get('administration/personalization/genders/{gender}/edit', [AdministrationGenderController::class, 'edit'])->name('administration.personalization.genders.edit');
    Route::put('administration/personalization/genders/{gender}', [AdministrationGenderController::class, 'update'])->name('administration.personalization.genders.update');
    Route::delete('administration/personalization/genders/{gender}', [AdministrationGenderController::class, 'destroy'])->name('administration.personalization.genders.destroy');

    // task categories
    Route::get('administration/personalization/task-categories/new', [AdministrationTaskCategoryController::class, 'new'])->name('administration.personalization.task-categories.new');
    Route::post('administration/personalization/task-categories', [AdministrationTaskCategoryController::class, 'create'])->name('administration.personalization.task-categories.create');
    Route::get('administration/personalization/task-categories/{taskCategory}/edit', [AdministrationTaskCategoryController::class, 'edit'])->name('administration.personalization.task-categories.edit');
    Route::put('administration/personalization/task-categories/{taskCategory}', [AdministrationTaskCategoryController::class, 'update'])->name('administration.personalization.task-categories.update');
    Route::delete('administration/personalization/task-categories/{taskCategory}', [AdministrationTaskCategoryController::class, 'destroy'])->name('administration.personalization.task-categories.destroy');

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
