<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateLifeEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateLifeEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_life_event(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);
        $lifeEvent = LifeEvent::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'description' => 'Got married',
            'comment' => 'At Central Perk',
            'icon' => 'heart',
            'bg_color' => '#ff0000',
            'text_color' => '#ffffff',
        ]);

        $updatedLifeEvent = (new UpdateLifeEvent(
            user: $user,
            lifeEvent: $lifeEvent,
            description: 'Got divorced',
            comment: 'At the courthouse',
            icon: 'broken-heart',
            bgColor: '#000000',
            textColor: '#ffffff',
            happenedAt: '2025-03-18',
            shouldBeReminded: true,
        ))->execute();

        $this->assertDatabaseHas('life_events', [
            'id' => $lifeEvent->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Got divorced', $updatedLifeEvent->description);
        $this->assertEquals('At the courthouse', $updatedLifeEvent->comment);
        $this->assertEquals('broken-heart', $updatedLifeEvent->icon);
        $this->assertEquals('#000000', $updatedLifeEvent->bg_color);
        $this->assertEquals('#ffffff', $updatedLifeEvent->text_color);

        $this->assertEquals('Mar 18, 2025', $updatedLifeEvent->specialDate->date);
        $this->assertTrue($updatedLifeEvent->specialDate->should_be_reminded);

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
                    $job->action === 'life_event_update' &&
                    $job->description === 'Updated a life event for Joey Tribbiani';
            }
        );
    }

    #[Test]
    public function it_fails_if_life_event_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $lifeEvent = LifeEvent::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateLifeEvent(
            user: $user,
            lifeEvent: $lifeEvent,
            description: 'Got divorced',
            comment: null,
            icon: null,
            bgColor: null,
            textColor: null,
            happenedAt: '2025-03-18',
            shouldBeReminded: true,
        ))->execute();
    }
}
