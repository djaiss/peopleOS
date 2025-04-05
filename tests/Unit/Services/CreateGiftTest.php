<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateGift;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateGiftTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_gift(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $gift = (new CreateGift(
            user: $user,
            person: $person,
            status: 'idea',
            name: 'Gift',
            occasion: 'Christmas',
            url: 'https://www.google.com',
        ))->execute();

        $this->assertDatabaseHas('gifts', [
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Gift', $gift->name);
        $this->assertEquals('Christmas', $gift->occasion);
        $this->assertEquals('https://www.google.com', $gift->url);
        $this->assertEquals('idea', $gift->status);

        $this->assertInstanceOf(
            Gift::class,
            $gift
        );

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
                return $job->action === 'gift_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Logged a gift for Ross Geller';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new CreateGift(
            user: $user,
            person: $person,
            status: 'idea',
            name: 'Gift',
            occasion: 'Christmas',
            url: 'https://www.google.com',
        ))->execute();
    }
}
