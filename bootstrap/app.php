<?php

use App\Http\Middleware\CheckContact;
use App\Http\Middleware\CheckUserPermissionAtLeastEditor;
use App\Http\Middleware\CheckVault;
use App\Http\Middleware\Locale;
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
        $middleware->append(Locale::class);
        $middleware->alias([
            'vault' => CheckVault::class,
            'contact' => CheckContact::class,
            'is_at_least_editor' => CheckUserPermissionAtLeastEditor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
