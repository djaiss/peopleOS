<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\TogglePastLoveRelationshipsVisibility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TogglePastLoveRelationshipsVisibilityTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;

    private User $user;

    private Person $person;

    #[Test]
    public function it_toggles_the_past_relationships_visibility(): void
    {
        Queue::fake();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
            'show_past_love_relationships' => true,
        ]);

        $person = (new TogglePastLoveRelationshipsVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();

        $this->assertFalse($person->show_past_love_relationships);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) {
                return $job->user->id === $this->user->id;
            },
        );
    }

    #[Test]
    public function it_fails_if_user_doesnt_belong_to_the_same_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create();
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        (new TogglePastLoveRelationshipsVisibility(
            user: $this->user,
            person: $this->person,
        ))->execute();
    }
}
