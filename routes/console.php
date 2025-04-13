<?php

declare(strict_types=1);

use App\Jobs\CountDailyUsers;
use App\Jobs\DeleteInactiveAccounts;
use App\Jobs\ProcessReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new CountDailyUsers())->dailyAt('00:20');
Schedule::job(new ProcessReminders())->dailyAt('00:00');
Schedule::job(new DeleteInactiveAccounts())->dailyAt('00:30');
