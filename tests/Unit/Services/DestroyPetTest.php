<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use App\Services\DestroyPet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyPetTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_pet(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Phoebe',
        ]);

        (new DestroyPet(
            user: $user,
            pet: $pet,
        ))->execute();

        $this->assertDatabaseMissing('pets', [
            'id' => $pet->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: fn(UpdateUserLastActivityDate $job) => $job->user->id === $user->id,
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdatePersonLastConsultedDate::class,
            callback: fn(UpdatePersonLastConsultedDate $job) => $job->person->id === $person->id,
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: fn(LogUserAction $job) => $job->action === 'pet_deletion'
                && $job->user->id === $user->id
                && $job->description === 'Deleted a pet: Phoebe',
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $pet = Pet::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyPet(
            user: $user,
            pet: $pet,
        ))->execute();
    }
}
