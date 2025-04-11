<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateLifeEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateLifeEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_life_event(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);

        $lifeEvent = (new CreateLifeEvent(
            user: $user,
            person: $person,
            description: 'Got married to Mike',
            comment: 'At Central Perk',
            icon: 'heart',
            bgColor: '#ff0000',
            textColor: '#ffffff',
            happenedAt: '2025-03-17',
            shouldBeReminded: true,
        ))->execute();

        $this->assertDatabaseHas('life_events', [
            'id' => $lifeEvent->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'happened_at' => '2025-03-17 00:00:00',
        ]);

        $this->assertEquals('Mar 17, 2025', $lifeEvent->specialDate->date);
        $this->assertEquals('Got married to Mike', $lifeEvent->description);
        $this->assertEquals('At Central Perk', $lifeEvent->comment);
        $this->assertEquals('heart', $lifeEvent->icon);
        $this->assertEquals('#ff0000', $lifeEvent->bg_color);
        $this->assertEquals('#ffffff', $lifeEvent->text_color);
        $this->assertTrue($lifeEvent->specialDate->should_be_reminded);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->user->id === $user->id &&
                    $job->action === 'life_event_creation' &&
                    $job->description === 'Logged a life event for Phoebe Buffay';
            }
        );
    }

    #[Test]
    public function it_does_not_create_a_special_date_if_should_be_reminded_is_false(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);

        $lifeEvent = (new CreateLifeEvent(
            user: $user,
            person: $person,
            description: 'Got married to Mike',
            comment: null,
            icon: null,
            bgColor: null,
            textColor: null,
            happenedAt: '2025-03-17',
            shouldBeReminded: false,
        ))->execute();

        $this->assertNull($lifeEvent->specialDate);
    }

    #[Test]
    public function it_fails_if_person_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreateLifeEvent(
            user: $user,
            person: $person,
            description: 'Got married to Mike',
            comment: null,
            icon: null,
            bgColor: null,
            textColor: null,
            happenedAt: '2025-03-17',
            shouldBeReminded: false,
        ))->execute();
    }
}
