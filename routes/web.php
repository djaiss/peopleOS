<?php

declare(strict_types=1);

use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\JoinOrganizationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationSettingsController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\WeekController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function (): void {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
