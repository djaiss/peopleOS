<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Address;
use App\Models\Person;
use App\Models\User;
use App\Services\CreateAddress;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateAddressTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_address_with_all_fields(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-06-29 10:00:00'));
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        Queue::fake();

        $address = (new CreateAddress(
            user: $user,
            person: $person,
            addressLine1: '495 Grove Street',
            addressLine2: 'Apt 19',
            city: 'New York',
            state: 'NY',
            postalCode: '10014',
            country: 'United States',
            isActive: true,
        ))->execute();

        $this->assertInstanceOf(
            Address::class,
            $address,
        );

        $this->assertEquals($user->account_id, $address->account_id);
        $this->assertEquals($person->id, $address->person_id);
        $this->assertEquals('495 Grove Street', $address->address_line_1);
        $this->assertEquals('Apt 19', $address->address_line_2);
        $this->assertEquals('New York', $address->city);
        $this->assertEquals('NY', $address->state);
        $this->assertEquals('10014', $address->postal_code);
        $this->assertEquals('United States', $address->country);
        $this->assertTrue($address->is_active);

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'is_active' => true,
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
                return $job->action === 'address_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created an address for Ross Geller';
            },
        );
    }

    #[Test]
    public function it_creates_an_address_without_person(): void
    {
        $user = User::factory()->create();
        Queue::fake();

        $address = (new CreateAddress(
            user: $user,
            addressLine1: '1290 Avenue of the Americas',
            city: 'New York',
            state: 'NY',
        ))->execute();

        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals($user->account_id, $address->account_id);
        $this->assertNull($address->person_id);
        $this->assertEquals('1290 Avenue of the Americas', $address->address_line_1);
        $this->assertEquals('New York', $address->city);
        $this->assertEquals('NY', $address->state);
    }

    #[Test]
    public function it_throws_an_exception_if_person_does_not_belong_to_account(): void
    {
        $user = User::factory()->create();
        $monica = Person::factory()->create([
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new CreateAddress(
            user: $user,
            person: $monica,
            addressLine1: '495 Grove Street',
        ))->execute();
    }
}
