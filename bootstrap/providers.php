<?php

declare(strict_types=1);

use LaravelDisposableEmail\LaravelDisposableEmailServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    LaravelDisposableEmailServiceProvider::class,
];
