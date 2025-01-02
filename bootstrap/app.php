<?php

use App\Http\Middleware\CheckAccount;
use App\Http\Middleware\CheckAPIContact;
use App\Http\Middleware\CheckContact;
use App\Http\Middleware\CheckJournal;
use App\Http\Middleware\CheckVault;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
