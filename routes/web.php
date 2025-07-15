<?php

declare(strict_types=1);

use App\Http\Controllers\Administration\Administration2faController;
use App\Http\Controllers\Administration\AdministrationAccountController;
use App\Http\Controllers\Administration\AdministrationAutoDeleteAccountController;
use App\Http\Controllers\Administration\AdministrationAvatarController;
use App\Http\Controllers\Administration\AdministrationController;
use App\Http\Controllers\Administration\AdministrationCreateTaskOnReminderController;
use App\Http\Controllers\Administration\AdministrationEmailsSentController;
use App\Http\Controllers\Administration\AdministrationGenderController;
use App\Http\Controllers\Administration\AdministrationLogsController;
use App\Http\Controllers\Administration\AdministrationMarketingController;
use App\Http\Controllers\Administration\AdministrationMarketingTestimonialController;
use App\Http\Controllers\Administration\AdministrationPasswordController;
use App\Http\Controllers\Administration\AdministrationPersonalizationController;
use App\Http\Controllers\Administration\AdministrationPersonalizationJournalTemplateController;
use App\Http\Controllers\Administration\AdministrationPruneAccountController;
use App\Http\Controllers\Administration\AdministrationSecurityController;
use App\Http\Controllers\Administration\AdministrationTaskCategoryController;
use App\Http\Controllers\Administration\AdministrationTimezoneController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Instance\InstanceCancellationReasonsController;
use App\Http\Controllers\Instance\InstanceController;
use App\Http\Controllers\Instance\InstanceDestroyAccountController;
use App\Http\Controllers\Instance\InstanceFreeAccountController;
use App\Http\Controllers\Instance\InstanceTestimonialsController;
use App\Http\Controllers\Instance\InstanceWaitlistController;
use App\Http\Controllers\Journal\EntryController;
use App\Http\Controllers\Journal\EntryMoodController;
use App\Http\Controllers\Journal\JournalController;
use App\Http\Controllers\Journal\MonthController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Marketing\ConfirmInscriptionToWaitlistController;
use App\Http\Controllers\Marketing\MarketingCompanyController;
use App\Http\Controllers\Marketing\MarketingController;
use App\Http\Controllers\Marketing\MarketingDocsController;
use App\Http\Controllers\Marketing\MarketingHandbookController;
use App\Http\Controllers\Marketing\MarketingPricingController;
use App\Http\Controllers\Marketing\MarketingVoteController;
use App\Http\Controllers\Marketing\MarketingVoteHelpfulController;
use App\Http\Controllers\Marketing\MarketingVoteUnhelpfulController;
use App\Http\Controllers\Marketing\MarketingWhyController;
use App\Http\Controllers\Marketing\WaitlistController;
use App\Http\Controllers\Persons\PersonAllergiesFoodController;
use App\Http\Controllers\Persons\PersonAddressController;
use App\Http\Controllers\Persons\PersonChildrenController;
use App\Http\Controllers\Persons\PersonController;
use App\Http\Controllers\Persons\PersonEncounterController;
use App\Http\Controllers\Persons\PersonEncounterToggleController;
use App\Http\Controllers\Persons\PersonExistingLoveController;
use App\Http\Controllers\Persons\PersonFoodController;
use App\Http\Controllers\Persons\PersonGiftController;
use App\Http\Controllers\Persons\PersonGiftTabController;
use App\Http\Controllers\Persons\PersonHowWeMetController;
use App\Http\Controllers\Persons\PersonInformationController;
use App\Http\Controllers\Persons\PersonLifeEventController;
use App\Http\Controllers\Persons\PersonLoveController;
use App\Http\Controllers\Persons\PersonNoteController;
use App\Http\Controllers\Persons\PersonPastLoveToggleController;
use App\Http\Controllers\Persons\PersonPetController;
use App\Http\Controllers\Persons\PersonPhysicalAppearanceController;
use App\Http\Controllers\Persons\PersonRelationshipController;
use App\Http\Controllers\Persons\PersonReminderController;
use App\Http\Controllers\Persons\PersonSearchController;
use App\Http\Controllers\Persons\PersonSearchLoveController;
use App\Http\Controllers\Persons\PersonSendTestReminderController;
use App\Http\Controllers\Persons\PersonSettingsAgeController;
use App\Http\Controllers\Persons\PersonSettingsAvatarController;
use App\Http\Controllers\Persons\PersonSettingsController;
use App\Http\Controllers\Persons\PersonTaskController;
use App\Http\Controllers\Persons\PersonTaskToggleController;
use App\Http\Controllers\Persons\PersonWorkController;
use App\Http\Controllers\StopReminderController;
use App\Http\Controllers\UpgradeAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/invitations/{user}/accept', [AdministrationController::class, 'accept'])->name('invitation.accept');

Route::put('/locale', [LocaleController::class, 'update'])->name('locale.update');

// stop a reminder from happening again
Route::get('/person/{hash}/reminder/{id}/stop', [StopReminderController::class, 'show'])
    ->name('reminder.stop')
    ->middleware('signed');

// waitlist
Route::get('/waitlist', [WaitlistController::class, 'index'])->name('waitlist.index');
Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
Route::get('/waitlist/confirm/{code}', [ConfirmInscriptionToWaitlistController::class, 'show'])->name('waitlist.confirm');

Route::middleware(['marketing', 'marketing.page'])->group(function (): void {
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
    Route::get('/company/handbook/marketing', [MarketingHandbookController::class, 'marketing'])->name('marketing.company.handbook.marketing.envision');
    Route::get('/company/handbook/social-media', [MarketingHandbookController::class, 'socialMedia'])->name('marketing.company.handbook.marketing.social-media');
    Route::get('/company/handbook/writing', [MarketingHandbookController::class, 'writing'])->name('marketing.company.handbook.marketing.writing');
    Route::get('/company/handbook/product-philosophy', [MarketingHandbookController::class, 'philosophy'])->name('marketing.company.handbook.marketing.product-philosophy');
    Route::get('/company/handbook/prioritize', [MarketingHandbookController::class, 'prioritize'])->name('marketing.company.handbook.marketing.prioritize');

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
    Route::get('/docs/api/tasks', [MarketingDocsController::class, 'tasks'])->name('marketing.docs.api.tasks');
    Route::get('/docs/api/journals', [MarketingDocsController::class, 'journals'])->name('marketing.docs.api.journals');
    Route::get('/docs/api/entries', [MarketingDocsController::class, 'entries'])->name('marketing.docs.api.entries');
    Route::get('/docs/api/update-age', [MarketingDocsController::class, 'updateAge'])->name('marketing.docs.api.update-age');
    Route::get('/docs/api/update-physical-appearance', [MarketingDocsController::class, 'updatePhysicalAppearance'])->name('marketing.docs.api.update-physical-appearance');
    Route::get('/docs/api/notes', [MarketingDocsController::class, 'notes'])->name('marketing.docs.api.notes');
    Route::get('/docs/api/life-events', [MarketingDocsController::class, 'lifeEvents'])->name('marketing.docs.api.life-events');
});

Route::middleware(['auth:sanctum', 'verified', 'throttle:60,1', 'set.locale'])->group(function (): void {
    // marketing
    Route::post('/vote/{page}/helpful', [MarketingVoteHelpfulController::class, 'update'])->name('marketing.vote-helpful');
    Route::post('/vote/{page}/unhelpful', [MarketingVoteUnhelpfulController::class, 'update'])->name('marketing.vote-unhelpful');
    Route::delete('/vote/{page}', [MarketingVoteController::class, 'update'])->name('marketing.destroy-vote');

    // upgrade
    Route::get('upgrade', [UpgradeAccountController::class, 'index'])->name('upgrade.index');

    Route::middleware(['subscription'])->group(function (): void {
        // dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // persons
        Route::get('persons', [PersonController::class, 'index'])->name('person.index');
        Route::get('persons/new', [PersonController::class, 'new'])->name('person.new');
        Route::post('persons', [PersonController::class, 'create'])->name('person.create');
        Route::post('persons/search', [PersonSearchController::class, 'create'])->name('person.search');

        Route::middleware(['person'])->group(function (): void {
            Route::get('persons/{slug}', [PersonController::class, 'show'])->name('person.show');
            Route::get('persons/{slug}/how-we-met', [PersonHowWeMetController::class, 'edit'])->name('person.how-we-met.edit');
            Route::get('persons/{slug}/how-we-met/toggle', [PersonHowWeMetController::class, 'create'])->name('person.how-we-met.create');
            Route::put('persons/{slug}/how-we-met', [PersonHowWeMetController::class, 'update'])->name('person.how-we-met.update');

            Route::get('persons/{slug}/information/edit', [PersonInformationController::class, 'edit'])->name('person.information.edit');
            Route::put('persons/{slug}/information', [PersonInformationController::class, 'update'])->name('person.information.update');

            Route::get('persons/{slug}/physical-appearance/edit', [PersonPhysicalAppearanceController::class, 'edit'])->name('person.physical-appearance.edit');
            Route::put('persons/{slug}/physical-appearance', [PersonPhysicalAppearanceController::class, 'update'])->name('person.physical-appearance.update');

            Route::get('persons/{slug}/encounters/new', [PersonEncounterController::class, 'new'])->name('person.encounter.new');
            Route::post('persons/{slug}/encounters', [PersonEncounterController::class, 'create'])->name('person.encounter.create');
            Route::get('persons/{slug}/encounters/toggle', [PersonEncounterToggleController::class, 'create'])->name('person.encounter.toggle');
            Route::get('persons/{slug}/encounters/{encounter}/edit', [PersonEncounterController::class, 'edit'])->name('person.encounter.edit');
            Route::put('persons/{slug}/encounters/{encounter}', [PersonEncounterController::class, 'update'])->name('person.encounter.update');
            Route::delete('persons/{slug}/encounters/{encounter}', [PersonEncounterController::class, 'destroy'])->name('person.encounter.destroy');

            // person settings
            Route::get('persons/{slug}/settings', [PersonSettingsController::class, 'index'])->name('person.settings.index');
            Route::put('persons/{slug}/settings', [PersonSettingsController::class, 'update'])->name('person.settings.update');
            Route::put('persons/{slug}/settings/avatar', [PersonSettingsAvatarController::class, 'update'])->name('person.settings.avatar.update');
            Route::put('persons/{slug}/settings/age', [PersonSettingsAgeController::class, 'update'])->name('person.settings.avatar.age');
            Route::delete('persons/{slug}', [PersonSettingsController::class, 'destroy'])->name('person.settings.destroy');

            // reminders
            Route::get('persons/{slug}/reminders', [PersonReminderController::class, 'index'])->name('person.reminder.index');
            Route::post('persons/{slug}/reminders/{specialDate}/test', [PersonSendTestReminderController::class, 'create'])->name('person.reminder.test');

            // tasks
            Route::get('persons/{slug}/tasks/new', [PersonTaskController::class, 'new'])->name('person.task.new');
            Route::post('persons/{slug}/tasks', [PersonTaskController::class, 'create'])->name('person.task.create');
            Route::middleware(['task'])->group(function (): void {
                Route::get('persons/{slug}/tasks/{task}', [PersonTaskController::class, 'edit'])->name('person.task.edit');
                Route::put('persons/{slug}/tasks/{task}', [PersonTaskController::class, 'update'])->name('person.task.update');
                Route::put('persons/{slug}/tasks/{task}/toggle', [PersonTaskToggleController::class, 'update'])->name('person.task.toggle');
                Route::delete('persons/{slug}/tasks/{task}', [PersonTaskController::class, 'destroy'])->name('person.task.destroy');
            });

            // persons notes
            Route::get('persons/{slug}/notes', [PersonNoteController::class, 'index'])->name('person.note.index');
            Route::post('persons/{slug}/notes', [PersonNoteController::class, 'create'])->name('person.note.create');
            Route::middleware(['note'])->group(function (): void {
                Route::get('persons/{slug}/notes/{note}/edit', [PersonNoteController::class, 'edit'])->name('person.note.edit');
                Route::put('persons/{slug}/notes/{note}', [PersonNoteController::class, 'update'])->name('person.note.update');
                Route::delete('persons/{slug}/notes/{note}', [PersonNoteController::class, 'destroy'])->name('person.note.destroy');
            });

            // work and passions
            Route::get('persons/{slug}/work', [PersonWorkController::class, 'index'])->name('person.work.index');
            Route::get('persons/{slug}/work/new', [PersonWorkController::class, 'new'])->name('person.work.new');
            Route::post('persons/{slug}/work', [PersonWorkController::class, 'create'])->name('person.work.create');
            Route::get('persons/{slug}/work/{entry}/edit', [PersonWorkController::class, 'edit'])->name('person.work.edit');
            Route::put('persons/{slug}/work/{entry}', [PersonWorkController::class, 'update'])->name('person.work.update');
            Route::delete('persons/{slug}/work/{entry}', [PersonWorkController::class, 'destroy'])->name('person.work.destroy');

            // food
            Route::get('persons/{slug}/food', [PersonFoodController::class, 'index'])->name('person.food.index');
            Route::get('persons/{slug}/food/allergies/edit', [PersonAllergiesFoodController::class, 'edit'])->name('person.food.allergies.edit');
            Route::put('persons/{slug}/food/allergies', [PersonAllergiesFoodController::class, 'update'])->name('person.food.allergies.update');

            // life events
            Route::get('persons/{slug}/life-events', [PersonLifeEventController::class, 'index'])->name('person.life-event.index');
            Route::get('persons/{slug}/life-events/new', [PersonLifeEventController::class, 'new'])->name('person.life-event.new');
            Route::post('persons/{slug}/life-events', [PersonLifeEventController::class, 'create'])->name('person.life-event.create');
            Route::middleware(['life_event'])->group(function (): void {
                Route::get('persons/{slug}/life-events/{lifeEvent}/edit', [PersonLifeEventController::class, 'edit'])->name('person.life-event.edit');
                Route::put('persons/{slug}/life-events/{lifeEvent}', [PersonLifeEventController::class, 'update'])->name('person.life-event.update');
                Route::delete('persons/{slug}/life-events/{lifeEvent}', [PersonLifeEventController::class, 'destroy'])->name('person.life-event.destroy');
            });

            // family
            Route::get('persons/{slug}/family', [PersonRelationshipController::class, 'index'])->name('person.family.index');
            Route::get('persons/{slug}/love/new', [PersonLoveController::class, 'new'])->name('person.love.new');
            Route::get('persons/{slug}/love/existing', [PersonSearchLoveController::class, 'new'])->name('person.love.existing.new');
            Route::post('persons/{slug}/love', [PersonLoveController::class, 'store'])->name('person.love.store');
            Route::post('persons/{slug}/love/search', [PersonSearchLoveController::class, 'search'])->name('person.love.search');
            Route::post('persons/{slug}/love/existing', [PersonExistingLoveController::class, 'store'])->name('person.love.existing.store');
            Route::get('persons/{slug}/love/toggle', [PersonPastLoveToggleController::class, 'create'])->name('person.love.toggle');
            Route::middleware(['love_relationship'])->group(function (): void {
                Route::delete('persons/{slug}/love/{loveRelationship}', [PersonLoveController::class, 'destroy'])->name('person.love.destroy');
            });
            Route::get('persons/{slug}/children/new', [PersonChildrenController::class, 'new'])->name('person.children.new');
            Route::post('persons/{slug}/children', [PersonChildrenController::class, 'store'])->name('person.children.store');
            Route::middleware(['child'])->group(function (): void {
                Route::delete('persons/{slug}/children/{child}', [PersonChildrenController::class, 'destroy'])->name('person.children.destroy');
            });

            // pet
            Route::get('persons/{slug}/pets/new', [PersonPetController::class, 'new'])->name('person.pet.new');
            Route::post('persons/{slug}/pets', [PersonPetController::class, 'store'])->name('person.pet.store');
            Route::middleware(['pet'])->group(function (): void {
                Route::get('persons/{slug}/pets/{pet}', [PersonPetController::class, 'edit'])->name('person.pet.edit');
                Route::put('persons/{slug}/pets/{pet}', [PersonPetController::class, 'update'])->name('person.pet.update');
                Route::delete('persons/{slug}/pets/{pet}', [PersonPetController::class, 'destroy'])->name('person.pet.destroy');
            });

            // gifts
            Route::get('persons/{slug}/gifts', [PersonGiftController::class, 'index'])->name('person.gift.index');
            Route::get('persons/{slug}/gifts/new', [PersonGiftController::class, 'new'])->name('person.gift.new');
            Route::post('persons/{slug}/gifts', [PersonGiftController::class, 'create'])->name('person.gift.create');
            Route::get('persons/{slug}/gifts/tab/{status}', [PersonGiftTabController::class, 'update'])->name('person.gift.tab.update');
            Route::middleware(['gift'])->group(function (): void {
                Route::get('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'edit'])->name('person.gift.edit');
                Route::put('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'update'])->name('person.gift.update');
                Route::delete('persons/{slug}/gifts/{gift}', [PersonGiftController::class, 'destroy'])->name('person.gift.destroy');
            });

            // addresses
            Route::get('persons/{slug}/addresses', [PersonAddressController::class, 'index'])->name('person.address.index');
            Route::get('persons/{slug}/addresses/new', [PersonAddressController::class, 'new'])->name('person.address.new');
            Route::post('persons/{slug}/addresses', [PersonAddressController::class, 'create'])->name('person.address.create');
            Route::middleware(['address'])->group(function (): void {
                Route::get('persons/{slug}/addresses/{address}', [PersonAddressController::class, 'edit'])->name('person.address.edit');
                Route::put('persons/{slug}/addresses/{address}', [PersonAddressController::class, 'update'])->name('person.address.update');
                Route::delete('persons/{slug}/addresses/{address}', [PersonAddressController::class, 'destroy'])->name('person.address.destroy');
            });
        });

        // journal
        Route::get('journal', [JournalController::class, 'index'])->name('journal.index');
        Route::get('journal/{year}/{month}', [MonthController::class, 'show'])->name('journal.month.show');

        Route::middleware(['entry'])->group(function (): void {
            Route::get('journal/{year}/{month}/{day}', [EntryController::class, 'show'])->name('journal.entry.show');
            Route::get('journal/{year}/{month}/{day}/mood/new', [EntryMoodController::class, 'new'])->name('journal.entry.mood.new');
            Route::post('journal/{year}/{month}/{day}/mood', [EntryMoodController::class, 'create'])->name('journal.entry.mood.create');
            Route::middleware(['mood'])->group(function (): void {
                Route::get('journal/{year}/{month}/{day}/mood/{mood}/edit', [EntryMoodController::class, 'edit'])->name('journal.entry.mood.edit');
                Route::put('journal/{year}/{month}/{day}/mood/{mood}', [EntryMoodController::class, 'update'])->name('journal.entry.mood.update');
                Route::delete('journal/{year}/{month}/{day}/mood/{mood}', [EntryMoodController::class, 'destroy'])->name('journal.entry.mood.destroy');
            });
        });
    });

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
    Route::put('administration/timezone', [AdministrationTimezoneController::class, 'update'])->name('administration.timezone.update');
    Route::put('administration/avatar', [AdministrationAvatarController::class, 'update'])->name('administration.avatar.update');
    Route::get('administration/logs', [AdministrationLogsController::class, 'index'])->name('administration.logs.index');
    Route::get('administration/emails-sent', [AdministrationEmailsSentController::class, 'index'])->name('administration.emails-sent.index');

    // security
    Route::get('administration/security', [AdministrationSecurityController::class, 'index'])->name('administration.security.index');
    Route::get('administration/security/new', [AdministrationSecurityController::class, 'new'])->name('administration.security.new');
    Route::post('administration/security', [AdministrationSecurityController::class, 'create'])->name('administration.security.create');
    Route::put('administration/password', [AdministrationPasswordController::class, 'update'])->name('administration.password.update');
    Route::delete('administration/security/{apiKeyId}', [AdministrationSecurityController::class, 'destroy'])->name('administration.security.destroy');

    // security - 2fa
    Route::get('administration/security/2fa/new', [Administration2faController::class, 'new'])->name('administration.security.2fa.new');
    Route::post('administration/security/2fa', [Administration2faController::class, 'store'])->name('administration.security.2fa.store');

    // auto delete account
    Route::put('administration/security/auto-delete-account', [AdministrationAutoDeleteAccountController::class, 'update'])->name('administration.security.auto-delete.update');

    // personalization
    Route::get('administration/personalization', [AdministrationPersonalizationController::class, 'index'])->name('administration.personalization.index');

    // marketing
    Route::get('administration/marketing', [AdministrationMarketingController::class, 'index'])->name('administration.marketing.index');
    Route::delete('administration/marketing/{page}', [AdministrationMarketingController::class, 'destroy'])->name('administration.marketing.destroy');
    Route::get('administration/marketing/testimonials/new', [AdministrationMarketingTestimonialController::class, 'new'])->name('administration.marketing.testimonial.new');
    Route::post('administration/marketing/testimonials', [AdministrationMarketingTestimonialController::class, 'create'])->name('administration.marketing.testimonial.create');
    Route::get('administration/marketing/testimonials/{testimonial}/edit', [AdministrationMarketingTestimonialController::class, 'edit'])->name('administration.marketing.testimonial.edit');
    Route::put('administration/marketing/testimonials/{testimonial}', [AdministrationMarketingTestimonialController::class, 'update'])->name('administration.marketing.testimonial.update');
    Route::delete('administration/marketing/testimonials/{testimonial}', [AdministrationMarketingTestimonialController::class, 'destroy'])->name('administration.marketing.testimonial.destroy');

    // create task on reminder
    Route::put('administration/personalization/create-task-on-reminder', [AdministrationCreateTaskOnReminderController::class, 'update'])->name('administration.personalization.create-task-on-reminder.update');

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

    // journal templates
    Route::get('administratibon/personalization/journal-templates/new', [AdministrationPersonalizationJournalTemplateController::class, 'new'])->name('administration.personalization.journal-templates.new');
    Route::post('administration/personalization/journal-templates', [AdministrationPersonalizationJournalTemplateController::class, 'create'])->name('administration.personalization.journal-templates.create');
    Route::get('administration/personalization/journal-templates/{journalTemplate}/edit', [AdministrationPersonalizationJournalTemplateController::class, 'edit'])->name('administration.personalization.journal-templates.edit');
    Route::put('administration/personalization/journal-templates/{journalTemplate}', [AdministrationPersonalizationJournalTemplateController::class, 'update'])->name('administration.personalization.journal-templates.update');
    Route::delete('administration/personalization/journal-templates/{journalTemplate}', [AdministrationPersonalizationJournalTemplateController::class, 'destroy'])->name('administration.personalization.journal-templates.destroy');

    // account
    Route::get('administration/account', [AdministrationAccountController::class, 'index'])->name('administration.account.index');
    Route::put('administration/prune', [AdministrationPruneAccountController::class, 'update'])->name('administration.account.prune');
    Route::delete('administration/account', [AdministrationAccountController::class, 'destroy'])->name('administration.account.destroy');

    Route::middleware(['instance.admin'])->group(function (): void {
        Route::get('instance', [InstanceController::class, 'index'])->name('instance.index');

        // accounts
        Route::get('instance/accounts/{account}', [InstanceController::class, 'show'])->name('instance.show');
        Route::delete('instance/accounts/{account}', [InstanceDestroyAccountController::class, 'destroy'])->name('instance.destroy');
        Route::put('instance/accounts/{account}/free', [InstanceFreeAccountController::class, 'update'])->name('instance.accounts.free');

        // testimonials
        Route::get('instance/testimonials', [InstanceTestimonialsController::class, 'index'])->name('instance.testimonial.index');
        Route::get('instance/testimonials/approved', [InstanceTestimonialsController::class, 'approved'])->name('instance.testimonial.approved');
        Route::get('instance/testimonials/rejected', [InstanceTestimonialsController::class, 'rejected'])->name('instance.testimonial.rejected');
        Route::get('instance/testimonials/all', [InstanceTestimonialsController::class, 'all'])->name('instance.testimonial.all');
        Route::put('instance/testimonials/{testimonial}/accept', [InstanceTestimonialsController::class, 'accept'])->name('instance.testimonial.accept');
        Route::get('instance/testimonials/{testimonial}/edit', [InstanceTestimonialsController::class, 'edit'])->name('instance.testimonial.edit');
        Route::put('instance/testimonials/{testimonial}/reject', [InstanceTestimonialsController::class, 'reject'])->name('instance.testimonial.reject');

        // account deletion reasons
        Route::get('instance/cancellation-reasons', [InstanceCancellationReasonsController::class, 'index'])->name('instance.cancellation-reasons.index');

        // waitlist
        Route::get('instance/waitlist', [InstanceWaitlistController::class, 'index'])->name('instance.waitlist.index');
        Route::get('instance/waitlist/not-confirmed', [InstanceWaitlistController::class, 'notConfirmed'])->name('instance.waitlist.not-confirmed');
        Route::get('instance/waitlist/approved', [InstanceWaitlistController::class, 'approved'])->name('instance.waitlist.approved');
        Route::get('instance/waitlist/rejected', [InstanceWaitlistController::class, 'rejected'])->name('instance.waitlist.rejected');
        Route::get('instance/waitlist/all', [InstanceWaitlistController::class, 'all'])->name('instance.waitlist.all');
        Route::put('instance/waitlist/{waitlist}/approve', [InstanceWaitlistController::class, 'approve'])->name('instance.waitlist.approve');
        Route::put('instance/waitlist/{waitlist}/reject', [InstanceWaitlistController::class, 'reject'])->name('instance.waitlist.reject');
    });
});

require __DIR__ . '/auth.php';
