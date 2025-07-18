<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AdministrationApiController;
use App\Http\Controllers\Api\Administration\AdministrationGenderController;
use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationLogsController;
use App\Http\Controllers\Api\Administration\AdministrationPruneAccountController;
use App\Http\Controllers\Api\Administration\AdministrationTaskCategoryController;
use App\Http\Controllers\Api\Administration\MeController;
use App\Http\Controllers\Api\Administration\MeTimezoneController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Journal\EntryController;
use App\Http\Controllers\Api\Journal\JournalController;
use App\Http\Controllers\Api\Persons\PersonAgeController;
use App\Http\Controllers\Api\Persons\PersonController;
use App\Http\Controllers\Api\Persons\PersonGiftController;
use App\Http\Controllers\Api\Persons\PersonLifeEventController;
use App\Http\Controllers\Api\Persons\PersonNoteController;
use App\Http\Controllers\Api\Persons\PersonPhysicalAppearanceController;
use App\Http\Controllers\Api\Persons\PersonTaskController;
use App\Http\Controllers\Api\Persons\PersonWorkHistoryController;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\ToggleTaskController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function (): void {
    Route::get('health', [HealthController::class, 'show'])->middleware('throttle:60,1')->name('health');

    // login
    Route::post('login', [LoginController::class, 'store'])->name('login');

    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {
        // logout
        Route::delete('logout', [LoginController::class, 'destroy'])->name('logout');

        // logged user
        Route::get('me', [MeController::class, 'show'])->name('me');
        Route::put('me', [MeController::class, 'update'])->name('me.update');
        Route::get('me/timezone', [MeTimezoneController::class, 'show'])->name('me.timezone');
        Route::put('me/timezone', [MeTimezoneController::class, 'update'])->name('me.timezone.update');

        // persons
        Route::get('persons', [PersonController::class, 'index']);
        Route::post('persons', [PersonController::class, 'create']);

        Route::put('tasks/{task}/toggle', [ToggleTaskController::class, 'update']);

        Route::middleware(['person.api', 'subscription'])->group(function (): void {
            Route::get('persons/{person}', [PersonController::class, 'show']);
            Route::put('persons/{person}', [PersonController::class, 'update']);
            Route::delete('persons/{person}', [PersonController::class, 'destroy']);

            // age
            Route::patch('persons/{person}/age', [PersonAgeController::class, 'update']);

            // physical appearance
            Route::patch('persons/{person}/physical-appearance', [PersonPhysicalAppearanceController::class, 'update']);

            // notes
            Route::get('persons/{person}/notes', [PersonNoteController::class, 'index']);
            Route::post('persons/{person}/notes', [PersonNoteController::class, 'create']);
            Route::middleware(['note'])->group(function (): void {
                Route::get('persons/{person}/notes/{note}', [PersonNoteController::class, 'show']);
                Route::put('persons/{person}/notes/{note}', [PersonNoteController::class, 'update']);
                Route::delete('persons/{person}/notes/{note}', [PersonNoteController::class, 'destroy']);
            });

            // work history
            Route::get('persons/{person}/work-history', [PersonWorkHistoryController::class, 'index']);
            Route::post('persons/{person}/work-history', [PersonWorkHistoryController::class, 'create']);
            Route::middleware(['work_history'])->group(function (): void {
                Route::get('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'show']);
                Route::put('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'update']);
                Route::delete('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'destroy']);
            });

            // gifts
            Route::get('persons/{person}/gifts', [PersonGiftController::class, 'index']);
            Route::post('persons/{person}/gifts', [PersonGiftController::class, 'create']);
            Route::middleware(['gift'])->group(function (): void {
                Route::get('persons/{person}/gifts/{gift}', [PersonGiftController::class, 'show']);
                Route::put('persons/{person}/gifts/{gift}', [PersonGiftController::class, 'update']);
                Route::delete('persons/{person}/gifts/{gift}', [PersonGiftController::class, 'destroy']);
            });

            // tasks
            Route::get('persons/{person}/tasks', [PersonTaskController::class, 'index']);
            Route::post('persons/{person}/tasks', [PersonTaskController::class, 'create']);
            Route::middleware(['task'])->group(function (): void {
                Route::get('persons/{person}/tasks/{task}', [PersonTaskController::class, 'show']);
                Route::put('persons/{person}/tasks/{task}', [PersonTaskController::class, 'update']);
                Route::delete('persons/{person}/tasks/{task}', [PersonTaskController::class, 'destroy']);
            });

            // life events
            Route::get('persons/{person}/life-events', [PersonLifeEventController::class, 'index']);
            Route::post('persons/{person}/life-events', [PersonLifeEventController::class, 'create']);
            Route::middleware(['life_event'])->group(function (): void {
                Route::get('persons/{person}/life-events/{lifeEvent}', [PersonLifeEventController::class, 'show']);
                Route::put('persons/{person}/life-events/{lifeEvent}', [PersonLifeEventController::class, 'update']);
                Route::delete('persons/{person}/life-events/{lifeEvent}', [PersonLifeEventController::class, 'destroy']);
            });
        });

        // journal
        Route::middleware(['subscription'])->group(function (): void {
            Route::get('journals', [JournalController::class, 'index']);
            Route::post('journals', [JournalController::class, 'create']);
            Route::middleware(['journal'])->group(function (): void {
                Route::get('journals/{journal}', [JournalController::class, 'show']);
                Route::put('journals/{journal}', [JournalController::class, 'update']);
                Route::delete('journals/{journal}', [JournalController::class, 'destroy']);

                Route::get('journals/{journal}/{year}/{month}/{day}', [EntryController::class, 'show']);
            });
        });

        // api keys
        Route::get('administration/api', [AdministrationApiController::class, 'index'])->name('administration.api');
        Route::get('administration/api/{id}', [AdministrationApiController::class, 'show'])->name('administration.api.show');
        Route::post('administration/api', [AdministrationApiController::class, 'create'])->name('administration.api.create');
        Route::delete('administration/api/{id}', [AdministrationApiController::class, 'destroy'])->name('administration.api.destroy');

        // prune account
        Route::put('administration/prune', [AdministrationPruneAccountController::class, 'update']);

        // logs
        Route::get('administration/logs', [AdministrationLogsController::class, 'index'])->name('administration.logs');
        Route::get('administration/logs/{log}', [AdministrationLogsController::class, 'show'])->name('administration.logs.show');

        // users
        Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update']);

        // genders
        Route::get('administration/genders', [AdministrationGenderController::class, 'index']);
        Route::post('administration/genders', [AdministrationGenderController::class, 'create']);
        Route::get('administration/genders/{gender}', [AdministrationGenderController::class, 'show'])->name('administration.genders.show');
        Route::put('administration/genders/{gender}', [AdministrationGenderController::class, 'update']);
        Route::delete('administration/genders/{gender}', [AdministrationGenderController::class, 'destroy']);

        // task categories
        Route::get('administration/task-categories', [AdministrationTaskCategoryController::class, 'index']);
        Route::post('administration/task-categories', [AdministrationTaskCategoryController::class, 'create']);
        Route::get('administration/task-categories/{taskCategory}', [AdministrationTaskCategoryController::class, 'show'])->name('administration.task-categories.show');
        Route::put('administration/task-categories/{taskCategory}', [AdministrationTaskCategoryController::class, 'update']);
        Route::delete('administration/task-categories/{taskCategory}', [AdministrationTaskCategoryController::class, 'destroy']);
    });
});
