<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdatePersonLastConsultedDate;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use App\Services\CreatePerson;
use Exception;
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
            maritalStatus: MaritalStatusType::UNKNOWN->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
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
        $this->assertEquals($person->id . '-ross-geller', $person->slug);
        $this->assertEquals(MaritalStatusType::UNKNOWN->value, $person->marital_status);
        $this->assertEquals(KidsStatusType::UNKNOWN->value, $person->kids_status);
        $this->assertNotNull($person->color);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{6}$/', $person->color);

        $this->assertInstanceOf(
            Person::class,
            $person,
        );

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
                return $job->action === 'person_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created the person called Ross Geller';
            },
        );
    }

    #[Test]
    public function it_fails_if_account_limit_is_reached(): void
    {
        config(['peopleos.account_limit' => 1]);

        $user = User::factory()->create();
        Person::factory()->count(2)->create([
            'account_id' => $user->account_id,
        ]);

        $this->expectException(Exception::class);
        (new CreatePerson(
            user: $user,
            gender: null,
            maritalStatus: MaritalStatusType::UNKNOWN->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
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
    }
}
