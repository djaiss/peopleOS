<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Address;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyAddress;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyAddressTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_address_with_person(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-06-29 10:00:00'));
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $address = Address::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'address_line_1' => '495 Grove Street',
        ]);
        Queue::fake();

        (new DestroyAddress(
            user: $user,
            address: $address,
        ))->execute();

        $this->assertDatabaseMissing('addresses', [
            'id' => $address->id,
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
                return $job->action === 'address_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Destroyed an address for Ross Geller';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_address_does_not_belong_to_account(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyAddress(
            user: $user,
            address: $address,
        ))->execute();
    }
}
