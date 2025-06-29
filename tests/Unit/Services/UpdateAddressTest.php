<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Address;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateAddress;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateAddressTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_an_address_with_all_fields(): void
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
            'address_line_2' => 'Apt 19',
            'city' => 'New York',
            'state' => 'NY',
            'postal_code' => '10014',
            'country' => 'United States',
            'is_active' => true,
        ]);
        Queue::fake();

        $updatedAddress = (new UpdateAddress(
            user: $user,
            address: $address,
            addressLine1: '90 Bedford Street',
            addressLine2: 'Apt 20',
            city: 'New York',
            state: 'NY',
            postalCode: '10014',
            country: 'United States',
            isActive: false,
        ))->execute();

        $this->assertInstanceOf(
            Address::class,
            $updatedAddress,
        );

        $this->assertEquals('90 Bedford Street', $updatedAddress->address_line_1);
        $this->assertEquals('Apt 20', $updatedAddress->address_line_2);
        $this->assertEquals('New York', $updatedAddress->city);
        $this->assertEquals('NY', $updatedAddress->state);
        $this->assertEquals('10014', $updatedAddress->postal_code);
        $this->assertEquals('United States', $updatedAddress->country);
        $this->assertFalse($updatedAddress->is_active);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'address_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated an address for Ross Geller';
            },
        );
    }

    #[Test]
    public function it_throws_an_exception_if_address_does_not_belong_to_account(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateAddress(
            user: $user,
            address: $address,
            addressLine1: '90 Bedford Street',
        ))->execute();
    }
}
