<?php

declare(strict_types=1);

use App\Http\Middleware\CheckGift;
use App\Http\Middleware\CheckInstanceAdministrator;
use App\Http\Middleware\CheckMarketingSiteEnabled;
use App\Http\Middleware\CheckNote;
use App\Http\Middleware\CheckPerson;
use App\Http\Middleware\CheckPersonApi;
use App\Http\Middleware\CheckSubscription;
use App\Http\Middleware\CheckTask;
use App\Http\Middleware\CheckWorkHistory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'subscription' => CheckSubscription::class,
            'person' => CheckPerson::class,
            'person.api' => CheckPersonApi::class,
            'note' => CheckNote::class,
            'work_history' => CheckWorkHistory::class,
            'gift' => CheckGift::class,
            'task' => CheckTask::class,
            'instance.admin' => CheckInstanceAdministrator::class,
            'marketing' => CheckMarketingSiteEnabled::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
