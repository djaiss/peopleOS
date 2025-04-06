<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enable strict mode for Eloquent models in non-production environments
        Model::shouldBeStrict(! app()->isProduction());

        // Enable prohibition of destructive commands in production environments
        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        // Enable lazy loading prevention in non-production environments
        // This will throw an exception if a lazy loading query is attempted
        Model::preventLazyLoading(! app()->isProduction());

        // Enable prevention of silently discarding attributes
        // This will throw an exception if an attribute is silently discarded
        Model::preventSilentlyDiscardingAttributes();

        // Enable prevention of accessing missing attributes
        // This will throw an exception if an attribute is accessed that does not exist
        Model::preventAccessingMissingAttributes();
    }
}
