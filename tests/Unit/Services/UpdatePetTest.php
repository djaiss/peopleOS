<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePetTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_pet(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $person->id,
            'name' => 'Joey',
            'species' => 'dog',
            'breed' => 'Bulldog',
            'gender' => 'male',
        ]);

        $updatedPet = (new UpdatePet(
            user: $user,
            pet: $pet,
            name: 'Phoebe',
            species: 'cat',
            breed: 'Siamese',
            gender: 'female',
            person: $person,
        ))->execute();

        $this->assertDatabaseHas('pets', [
            'id' => $pet->id,
            'account_id' => $user->account_id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Phoebe', $updatedPet->name);
        $this->assertEquals('cat', $updatedPet->species);
        $this->assertEquals('Siamese', $updatedPet->breed);
        $this->assertEquals('female', $updatedPet->gender);

        $this->assertInstanceOf(
            Pet::class,
            $updatedPet,
        );

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
            callback: fn(LogUserAction $job) => $job->action === 'pet_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated a pet: Phoebe',
        );
    }

    #[Test]
    public function it_fails_if_user_and_pet_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $pet = Pet::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePet(
            user: $user,
            pet: $pet,
            name: 'Rachel',
            species: 'bird',
            breed: 'Parakeet',
            gender: 'female',
            person: $person,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_user_and_person_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePet(
            user: $user,
            pet: $pet,
            name: 'Monica',
            species: 'hamster',
            breed: 'Syrian',
            gender: 'female',
            person: $person,
        ))->execute();
    }
}
