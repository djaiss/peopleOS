<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Pet;
use App\Models\Person;
use App\Models\User;
use App\Services\CreatePet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatePetTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_pet(): void
    {
        Queue::fake();

        $account = Account::factory()->create();
        $user = User::factory()->create([
            'account_id' => $account->id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $pet = (new CreatePet(
            user: $user,
            account: $account,
            name: 'Phoebe',
            species: 'cat',
            breed: 'Siamese',
            gender: 'female',
            person: $person,
        ))->execute();

        $this->assertDatabaseHas('pets', [
            'account_id' => $account->id,
            'person_id' => $person->id,
        ]);

        $this->assertEquals('Phoebe', $pet->name);
        $this->assertEquals('cat', $pet->species);
        $this->assertEquals('Siamese', $pet->breed);
        $this->assertEquals('female', $pet->gender);
        $this->assertInstanceOf(Pet::class, $pet);

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
            callback: fn(LogUserAction $job) => $job->action === 'pet_creation'
                && $job->user->id === $user->id
                && $job->description === 'Logged a pet: Phoebe',
        );
    }

    #[Test]
    public function it_fails_if_user_and_account_do_not_match(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->expectException(ModelNotFoundException::class);

        (new CreatePet(
            user: $user,
            account: $account,
            name: 'Joey',
            species: 'dog',
            breed: 'Bulldog',
            gender: 'male',
            person: $person,
        ))->execute();
    }
}
