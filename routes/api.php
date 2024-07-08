<?php

use App\Http\Controllers\Api\Settings\MeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [MeController::class, 'show'])->name('me');
});
