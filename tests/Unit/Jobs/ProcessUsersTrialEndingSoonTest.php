<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessUsersTrialEndingSoon;
use App\Jobs\SendTrialEndingSoonEmail;
use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProcessUsersTrialEndingSoonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_dispatches_email_for_users_with_trial_ending_in_5_days(): void
    {
        Queue::fake();

        Carbon::setTestNow(Carbon::parse('2024-06-01 10:00:00'));

        $account = Account::factory()->create([
            'trial_ends_at' => '2024-06-06 10:00:00',
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'monica.geller@friends.com',
        ]);

        $job = new ProcessUsersTrialEndingSoon();
        $job->dispatch();
        $job->handle();

        Queue::assertPushed(
            SendTrialEndingSoonEmail::class,
            function (SendTrialEndingSoonEmail $queuedJob): bool {
                return $queuedJob->email === 'monica.geller@friends.com';
            },
        );
        Queue::assertPushedOn('low', SendTrialEndingSoonEmail::class);
    }

    #[Test]
    public function it_dispatches_email_for_users_with_trial_ending_in_5_days_with_different_hours(): void
    {
        Queue::fake();

        Carbon::setTestNow(Carbon::parse('2024-06-01 10:00:00'));

        $account = Account::factory()->create([
            'trial_ends_at' => '2024-06-06 13:00:00',
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'monica.geller@friends.com',
        ]);

        $job = new ProcessUsersTrialEndingSoon();
        $job->dispatch();
        $job->handle();

        Queue::assertPushed(
            SendTrialEndingSoonEmail::class,
            function (SendTrialEndingSoonEmail $queuedJob): bool {
                return $queuedJob->email === 'monica.geller@friends.com';
            },
        );
        Queue::assertPushedOn('low', SendTrialEndingSoonEmail::class);
    }

    #[Test]
    public function it_does_not_dispatch_for_accounts_with_lifetime_access(): void
    {
        Queue::fake();

        Carbon::setTestNow(Carbon::parse('2024-06-01 10:00:00'));

        $account = Account::factory()->create([
            'trial_ends_at' => '2024-06-06 10:00:00',
            'has_lifetime_access' => true,
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'monica.geller@friends.com',
        ]);

        $job = new ProcessUsersTrialEndingSoon();
        $job->dispatch();
        $job->handle();

        Queue::assertNotPushed(SendTrialEndingSoonEmail::class);
    }

    #[Test]
    public function it_does_not_dispatch_for_accounts_with_trial_end_dates_in_more_than_5_days_from_now(): void
    {
        Queue::fake();

        Carbon::setTestNow(Carbon::parse('2024-06-01 10:00:00'));

        $account = Account::factory()->create([
            'trial_ends_at' => '2024-06-07 10:00:00',
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);

        $job = new ProcessUsersTrialEndingSoon();
        $job->dispatch();
        $job->handle();

        Queue::assertNotPushed(
            SendTrialEndingSoonEmail::class,
            function (SendTrialEndingSoonEmail $queuedJob): bool {
                return $queuedJob->email === 'ross.geller@friends.com';
            },
        );
    }

    #[Test]
    public function it_does_not_dispatch_for_accounts_with_trial_end_dates_in_less_than_5_days_from_now(): void
    {
        Queue::fake();

        Carbon::setTestNow(Carbon::parse('2024-06-01 10:00:00'));

        $account = Account::factory()->create([
            'trial_ends_at' => '2024-06-04 10:00:00',
        ]);

        User::factory()->create([
            'account_id' => $account->id,
            'email' => 'ross.geller@friends.com',
        ]);

        $job = new ProcessUsersTrialEndingSoon();
        $job->dispatch();
        $job->handle();

        Queue::assertNotPushed(
            SendTrialEndingSoonEmail::class,
            function (SendTrialEndingSoonEmail $queuedJob): bool {
                return $queuedJob->email === 'ross.geller@friends.com';
            },
        );
    }
}
