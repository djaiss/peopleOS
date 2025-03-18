<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\GiftStatus;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateGift;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateGiftTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_gift(): void
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
            'status' => GiftStatus::IDEA->value,
            'name' => 'Original Gift',
            'occasion' => 'Birthday',
            'url' => 'https://example.com',
        ]);

        $updatedGift = (new UpdateGift(
            user: $user,
            person: $person,
            gift: $gift,
            status: GiftStatus::GIVEN->value,
            name: 'Updated Gift',
            occasion: 'Christmas',
            url: 'https://updated-example.com',
            giftedAt: '2023-12-25',
        ))->execute();

        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Updated Gift', $updatedGift->name);
        $this->assertEquals('Christmas', $updatedGift->occasion);
        $this->assertEquals('https://updated-example.com', $updatedGift->url);
        $this->assertEquals('given', $updatedGift->status);
        $this->assertEquals('2023-12-25', $updatedGift->gifted_at->format('Y-m-d'));

        $this->assertInstanceOf(
            Gift::class,
            $updatedGift
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'gift_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated a gift for Ross Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_and_gift_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateGift(
            user: $user,
            person: $person,
            gift: $gift,
            status: GiftStatus::GIVEN->value,
            name: 'Updated Gift',
            occasion: 'Christmas',
            url: 'https://updated-example.com',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new UpdateGift(
            user: $user,
            person: $person,
            gift: $gift,
            status: GiftStatus::GIVEN->value,
            name: 'Updated Gift',
            occasion: 'Christmas',
            url: 'https://updated-example.com',
        ))->execute();
    }

    #[Test]
    public function it_fails_if_gift_is_not_associated_with_the_person(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $otherPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $otherPerson->id,
        ]);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Gift is not associated with the person');

        (new UpdateGift(
            user: $user,
            person: $person,
            gift: $gift,
            status: GiftStatus::GIVEN->value,
            name: 'Updated Gift',
            occasion: 'Christmas',
            url: 'https://updated-example.com',
        ))->execute();
    }

    #[Test]
    public function it_updates_only_provided_fields(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gift = Gift::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'status' => GiftStatus::IDEA->value,
            'name' => 'Original Gift',
            'occasion' => 'Birthday',
            'url' => 'https://example.com',
        ]);

        $updatedGift = (new UpdateGift(
            user: $user,
            person: $person,
            gift: $gift,
            status: GiftStatus::GIVEN->value,
        ))->execute();

        $this->assertEquals('Original Gift', $updatedGift->name);
        $this->assertNull($updatedGift->occasion);
        $this->assertNull($updatedGift->url);
        $this->assertEquals('given', $updatedGift->status);
    }
}
