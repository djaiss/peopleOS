<?php

declare(strict_types=1);

use App\Http\Controllers\Administration\AdministrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function (): void {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('administration', [AdministrationController::class, 'index'])->name('administration.index');
    Route::put('administration', [AdministrationController::class, 'update'])->name('administration.update');
});

require __DIR__.'/auth.php';
