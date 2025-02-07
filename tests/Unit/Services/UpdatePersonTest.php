<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\KidsStatusType;
use App\Enums\MaritalStatusType;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePerson;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_person(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $updatedPerson = (new UpdatePerson(
            user: $user,
            person: $person,
            gender: $gender,
            maritalStatus: MaritalStatusType::UNKNOWN->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
            firstName: 'Monica',
            lastName: 'Geller',
            middleName: 'E',
            nickname: 'Mon',
            maidenName: 'Geller',
            prefix: 'Ms',
            suffix: 'Jr',
            canBeDeleted: false,
            isListed: false,
        ))->execute();

        $this->assertDatabaseHas('persons', [
            'id' => $person->id,
            'account_id' => $user->account_id,
            'gender_id' => $gender->id,
            'can_be_deleted' => false,
            'is_listed' => false,
        ]);

        $this->assertEquals(MaritalStatusType::UNKNOWN->value, $person->marital_status);
        $this->assertEquals(KidsStatusType::UNKNOWN->value, $person->kids_status);
        $this->assertEquals('Monica', $person->first_name);
        $this->assertEquals('Geller', $person->last_name);
        $this->assertEquals($person->id.'-monica-geller', $person->slug);

        $this->assertInstanceOf(
            Person::class,
            $updatedPerson
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'person_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated the person called Monica Geller';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePerson(
            user: $user,
            person: $person,
            gender: null,
            maritalStatus: MaritalStatusType::UNKNOWN->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
            firstName: 'Monica',
            lastName: 'Geller',
            middleName: null,
            nickname: null,
            maidenName: null,
            prefix: null,
            suffix: null,
            canBeDeleted: false,
            isListed: false,
        ))->execute();
    }

    #[Test]
    public function it_fails_if_gender_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $gender = Gender::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdatePerson(
            user: $user,
            person: $person,
            gender: $gender,
            maritalStatus: MaritalStatusType::UNKNOWN->value,
            kidsStatus: KidsStatusType::UNKNOWN->value,
            firstName: 'Monica',
            lastName: 'Geller',
            middleName: null,
            nickname: null,
            maidenName: null,
            prefix: null,
            suffix: null,
            canBeDeleted: false,
            isListed: false,
        ))->execute();
    }
}
