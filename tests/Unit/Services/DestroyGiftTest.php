<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyGift;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyGiftTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_gift(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        (new DestroyGift(
            user: $user,
            gift: $gift,
        ))->execute();

        $this->assertDatabaseMissing('gifts', [
            'id' => $gift->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdatePersonLastConsultedDate::class,
            callback: function (UpdatePersonLastConsultedDate $job) use ($person): bool {
                return $job->person->id === $person->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'gift_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a gift for Ross Geller';
            },
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $gift = Gift::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyGift(
            user: $user,
            gift: $gift,
        ))->execute();
    }
}
