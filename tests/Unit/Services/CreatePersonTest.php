<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use App\Services\CreatePerson;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreatePersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_person(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->executeService($user, $gender);
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $gender = Gender::factory()->create();
        $this->executeService($user, $gender);
    }

    private function executeService(User $user, Gender $gender): void
    {
        Queue::fake();

        $person = (new CreatePerson(
            user: $user,
            gender: $gender,
            firstName: 'Ross',
            lastName: 'Geller',
            middleName: '',
            nickname: '',
            maidenName: '',
            prefix: '',
            suffix: '',
            canBeDeleted: true,
            isListed: true,
        ))->execute();

        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
            'account_id' => $user->account_id,
            'gender_id' => $gender->id,
            'can_be_deleted' => true,
            'is_listed' => true,
        ]);

        $this->assertEquals('Ross', $person->first_name);
        $this->assertEquals('Geller', $person->last_name);
        $this->assertEquals($person->id.'-ross-geller', $person->slug);

        $this->assertInstanceOf(
            Person::class,
            $person
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'person_creation'
                && $job->user->id === $user->id
                && $job->description === 'Created the person called Ross Geller';
        });
    }
}
