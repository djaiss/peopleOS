<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Account;
use App\Models\User;
use App\Services\DestroyAccountBecauseInactivity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyAccountBecauseInactivityTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_deletes_account_when_all_users_have_been_inactive_for_six_months(): void
    {
        $account = Account::factory()->create();

        // Create users with last activity more than 6 months ago
        User::factory()->count(3)->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subMonths(7),
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_deletes_account_when_all_users_have_never_logged_in(): void
    {
        $account = Account::factory()->create();

        // Create users who have never logged in (null last_activity_at)
        User::factory()->count(2)->create([
            'account_id' => $account->id,
            'last_activity_at' => null,
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_deletes_account_when_some_users_never_logged_in_and_others_inactive(): void
    {
        $account = Account::factory()->create();

        // Create users who have never logged in
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => null,
        ]);

        // Create users who have been inactive for more than 6 months
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subMonths(8),
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_does_not_delete_account_if_any_user_has_been_active_within_six_months(): void
    {
        $account = Account::factory()->create();

        // Create users who have been inactive for more than 6 months
        User::factory()->count(2)->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subMonths(7),
        ]);

        // Create one active user
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subMonths(5),
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_does_not_delete_account_if_all_users_are_active(): void
    {
        $account = Account::factory()->create();

        // Create active users
        User::factory()->count(3)->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subDays(10),
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
        ]);
    }

    #[Test]
    public function it_does_not_delete_account_with_mixture_of_active_and_inactive_users(): void
    {
        $account = Account::factory()->create();

        // Create users who have never logged in
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => null,
        ]);

        // Create users who have been inactive for more than 6 months
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subMonths(9),
        ]);

        // Create one active user
        User::factory()->create([
            'account_id' => $account->id,
            'last_activity_at' => now()->subDays(2),
        ]);

        $service = new DestroyAccountBecauseInactivity($account);
        $service->execute();

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
        ]);
    }
}
