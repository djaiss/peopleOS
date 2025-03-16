<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\AdministrationApiController;
use App\Http\Controllers\Api\Administration\AdministrationGenderController;
use App\Http\Controllers\Api\Administration\AdministrationInviteUserAgainController;
use App\Http\Controllers\Api\Administration\AdministrationLogsController;
use App\Http\Controllers\Api\Administration\AdministrationPruneAccountController;
use App\Http\Controllers\Api\Administration\MeController;
use App\Http\Controllers\Api\Administration\MeTimezoneController;
use App\Http\Controllers\Api\Persons\PersonController;
use App\Http\Controllers\Api\Persons\PersonNoteController;
use App\Http\Controllers\Api\Persons\PersonWorkHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {
    // logged user
    Route::get('me', [MeController::class, 'show']);
    Route::put('me', [MeController::class, 'update']);
    Route::get('me/timezone', [MeTimezoneController::class, 'show']);
    Route::put('me/timezone', [MeTimezoneController::class, 'update']);

    // persons
    Route::get('persons', [PersonController::class, 'index']);
    Route::post('persons', [PersonController::class, 'create']);

    Route::middleware(['person.api'])->group(function (): void {
        Route::get('persons/{person}', [PersonController::class, 'show']);
        Route::put('persons/{person}', [PersonController::class, 'update']);
        Route::delete('persons/{person}', [PersonController::class, 'destroy']);

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
    });

    // api keys
    Route::get('administration/api', [AdministrationApiController::class, 'index']);
    Route::post('administration/api', [AdministrationApiController::class, 'create']);
    Route::delete('administration/api/{id}', [AdministrationApiController::class, 'destroy']);

    // prune account
    Route::put('administration/prune', [AdministrationPruneAccountController::class, 'update']);

    // logs
    Route::get('administration/logs', [AdministrationLogsController::class, 'index']);

    // users
    Route::put('administration/users/{user}/invite', [AdministrationInviteUserAgainController::class, 'update']);

    // genders
    Route::get('administration/genders', [AdministrationGenderController::class, 'index']);
    Route::post('administration/genders', [AdministrationGenderController::class, 'create']);
    Route::put('administration/genders/{gender}', [AdministrationGenderController::class, 'update']);
    Route::delete('administration/genders/{gender}', [AdministrationGenderController::class, 'destroy']);
});
