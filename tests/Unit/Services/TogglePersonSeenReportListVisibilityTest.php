<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\TogglePersonSeenReportListVisibility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TogglePersonSeenReportListVisibilityTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;

    private User $user;

    private Person $person;

    /** @test */
    public function it_toggles_the_person_seen_report_list_visibility(): void
    {
        Queue::fake();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
            'encounters_shown' => true,
        ]);

        $person = (new TogglePersonSeenReportListVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();

        $this->assertFalse($person->encounters_shown);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function ($job) {
            return $job->user->id === $this->user->id;
        });
    }

    /** @test */
    public function it_fails_if_user_doesnt_belong_to_the_same_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create();
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        (new TogglePersonSeenReportListVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();
    }
}
