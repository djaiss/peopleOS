<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\ToggleHowIMetVisibility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ToggleHowIMetVisibilityTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;

    private User $user;

    private Person $person;

    /** @test */
    public function it_toggles_the_how_i_met_visibility(): void
    {
        Queue::fake();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
            'how_we_met_shown' => true,
        ]);

        $person = (new ToggleHowIMetVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();

        $this->assertFalse($person->how_we_met_shown);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) {
                return $job->user->id === $this->user->id;
            }
        );
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

        (new ToggleHowIMetVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();
    }
}
