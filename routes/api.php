<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Administration\MeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function (): void {

    Route::get('me', [MeController::class, 'show'])->name('me');
    Route::put('me', [MeController::class, 'update'])->name('me.update');
});
