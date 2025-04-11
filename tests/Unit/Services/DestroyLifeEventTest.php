<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyLifeEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyLifeEventTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_life_event(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
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

        (new DestroyLifeEvent(
            user: $user,
            lifeEvent: $lifeEvent,
        ))->execute();

        $this->assertDatabaseMissing('life_events', [
            'id' => $lifeEvent->id,
        ]);

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
                    $job->action === 'life_event_deletion' &&
                    $job->description === 'Deleted a life event for Monica Geller';
            }
        );
    }

    #[Test]
    public function it_fails_if_life_event_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $lifeEvent = LifeEvent::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyLifeEvent(
            user: $user,
            lifeEvent: $lifeEvent,
        ))->execute();
    }
}
