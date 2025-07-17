<?php

declare(strict_types=1);

use App\Jobs\CountDailyUsers;
use App\Jobs\DeleteInactiveAccounts;
use App\Jobs\ProcessReminders;
use App\Jobs\ProcessUsersTrialEndingSoon;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CountDailyUsers(), 'low')->dailyAt('00:20');
Schedule::job(new ProcessReminders(), 'low')->dailyAt('00:00');
Schedule::job(new DeleteInactiveAccounts(), 'low')->dailyAt('00:30');
Schedule::job(new ProcessUsersTrialEndingSoon(), 'low')->dailyAt('01:00');
