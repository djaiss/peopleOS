<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Address;
use App\Models\EmailSent;
use App\Models\Encounter;
use App\Models\Gender;
use App\Models\JournalTemplate;
use App\Models\LifeEvent;
use App\Models\Log;
use App\Models\Person;
use App\Models\Pet;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_many_users(): void
    {
        $account = Account::factory()->create();
        User::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->users()->exists());
    }

    #[Test]
    public function it_has_many_logs(): void
    {
        $account = Account::factory()->create();
        Log::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->logs()->exists());
    }

    #[Test]
    public function it_has_many_genders(): void
    {
        $account = Account::factory()->create();
        Gender::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->genders()->exists());
    }

    #[Test]
    public function it_has_many_persons(): void
    {
        $account = Account::factory()->create();
        Person::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->persons()->exists());
    }

    #[Test]
    public function it_has_many_encounters(): void
    {
        $account = Account::factory()->create();
        Encounter::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->encounters()->exists());
    }

    #[Test]
    public function it_has_many_task_categories(): void
    {
        $account = Account::factory()->create();
        TaskCategory::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->taskCategories()->exists());
    }

    #[Test]
    public function it_has_many_tasks(): void
    {
        $account = Account::factory()->create();
        Task::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->tasks()->exists());
    }

    #[Test]
    public function it_has_many_journal_templates(): void
    {
        $account = Account::factory()->create();
        JournalTemplate::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->journalTemplates()->exists());
    }

    #[Test]
    public function it_has_many_life_events(): void
    {
        $account = Account::factory()->create();
        LifeEvent::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->lifeEvents()->exists());
    }

    #[Test]
    public function it_has_many_emails_sent(): void
    {
        $account = Account::factory()->create();
        EmailSent::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->emailsSent()->exists());
    }

    #[Test]
    public function it_has_many_pets(): void
    {
        $account = Account::factory()->create();
        Pet::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->pets()->exists());
    }

    #[Test]
    public function it_has_many_addresses(): void
    {
        $account = Account::factory()->create();
        Address::factory()->count(2)->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($account->addresses()->exists());
    }

    public function it_checks_if_the_account_is_in_trial(): void
    {
        config(['peopleos.enable_paid_version' => true]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->addDays(30),
        ]);
        $this->assertTrue($account->isInTrial());
    }

    #[Test]
    public function it_checks_if_the_account_needs_to_pay(): void
    {
        config(['peopleos.enable_paid_version' => true]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subMinutes(1),
        ]);
        $this->assertTrue($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->addMinutes(1),
        ]);
        $this->assertFalse($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => true,
        ]);
        $this->assertFalse($account->needsToPay());

        config(['peopleos.enable_paid_version' => false]);
        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subDays(31),
        ]);
        $this->assertFalse($account->needsToPay());

        $account = Account::factory()->create([
            'has_lifetime_access' => false,
            'trial_ends_at' => now()->subDays(29),
        ]);
        $this->assertFalse($account->needsToPay());
    }

    #[Test]
    public function it_checks_if_the_account_is_over_the_account_limit(): void
    {
        config(['peopleos.account_limit' => 2]);

        $account = Account::factory()->create();
        Person::factory()->count(config('peopleos.account_limit'))->create([
            'account_id' => $account->id,
        ]);
        $this->assertFalse($account->isOverAccountLimit());

        Person::factory()->create([
            'account_id' => $account->id,
        ]);
        $this->assertTrue($account->isOverAccountLimit());
    }
}
