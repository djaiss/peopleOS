<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AdministrationApiController;
use App\Http\Controllers\Api\Administration\AdministrationGenderController;
use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationLogsController;
use App\Http\Controllers\Api\Administration\AdministrationPruneAccountController;
use App\Http\Controllers\Api\Administration\MeController;
use App\Http\Controllers\Api\Persons\PersonController;
use App\Http\Controllers\Api\Persons\PersonNoteController;
use App\Http\Controllers\Api\Persons\PersonWorkHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {
    // logged user
    Route::get('me', [MeController::class, 'show'])->name('me');
    Route::put('me', [MeController::class, 'update'])->name('me.update');

    // persons
    Route::get('persons', [PersonController::class, 'index'])->name('persons.index');
    Route::post('persons', [PersonController::class, 'create'])->name('persons.create');

    Route::middleware(['person.api'])->group(function (): void {
        Route::get('persons/{person}', [PersonController::class, 'show'])->name('persons.show');
        Route::put('persons/{person}', [PersonController::class, 'update'])->name('persons.update');
        Route::delete('persons/{person}', [PersonController::class, 'destroy'])->name('persons.destroy');

        // notes
        Route::get('persons/{person}/notes', [PersonNoteController::class, 'index'])->name('persons.notes.index');
        Route::post('persons/{person}/notes', [PersonNoteController::class, 'create'])->name('persons.notes.create');
        Route::middleware(['note'])->group(function (): void {
            Route::get('persons/{person}/notes/{note}', [PersonNoteController::class, 'show'])->name('persons.notes.show');
            Route::put('persons/{person}/notes/{note}', [PersonNoteController::class, 'update'])->name('persons.notes.update');
            Route::delete('persons/{person}/notes/{note}', [PersonNoteController::class, 'destroy'])->name('persons.notes.destroy');
        });

        // work history
        Route::get('persons/{person}/work-history', [PersonWorkHistoryController::class, 'index'])->name('persons.work-history.index');
        Route::post('persons/{person}/work-history', [PersonWorkHistoryController::class, 'create'])->name('persons.work-history.create');
        Route::middleware(['work_history'])->group(function (): void {
            Route::get('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'show'])->name('persons.work-history.show');
            Route::put('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'update'])->name('persons.work-history.update');
            Route::delete('persons/{person}/work-history/{entry}', [PersonWorkHistoryController::class, 'destroy'])->name('persons.work-history.destroy');
        });
    });

    // api keys
    Route::get('administration/api', [AdministrationApiController::class, 'index'])->name('administration.api.index');
    Route::post('administration/api', [AdministrationApiController::class, 'create'])->name('administration.api.create');
    Route::delete('administration/api/{id}', [AdministrationApiController::class, 'destroy'])->name('administration.api.destroy');

    // prune account
    Route::put('administration/prune', [AdministrationPruneAccountController::class, 'update'])->name('account.prune');

    // logs
    Route::get('administration/logs', [AdministrationLogsController::class, 'index'])->name('administration.logs.index');

    // users
    Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update'])->name('users.invite');

    // genders
    Route::get('administration/genders', [AdministrationGenderController::class, 'index'])->name('administration.genders.index');
    Route::post('administration/genders', [AdministrationGenderController::class, 'create'])->name('administration.genders.create');
    Route::put('administration/genders/{gender}', [AdministrationGenderController::class, 'update'])->name('administration.genders.update');
    Route::delete('administration/genders/{gender}', [AdministrationGenderController::class, 'destroy'])->name('administration.genders.destroy');
});
