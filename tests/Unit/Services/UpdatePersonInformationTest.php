<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdatePersonInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdatePersonInformationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_the_person_information(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $person = Person::factory()->create(['account_id' => $user->account_id]);

        $updateData = [
            'timezone' => 'America/New_York',
            'nationalities' => 'American, Canadian',
            'languages' => 'English, French',
        ];

        $person = (new UpdatePersonInformation(
            user: $user,
            person: $person,
            timezone: $updateData['timezone'],
            nationalities: $updateData['nationalities'],
            languages: $updateData['languages'],
        ))->execute();

        $this->assertInstanceOf(Person::class, $person);
        $this->assertEquals('America/New_York', $person->timezone);
        $this->assertEquals('American, Canadian', $person->nationalities);
        $this->assertEquals('English, French', $person->languages);

        Queue::assertPushed(LogUserAction::class, function ($job) use ($user, $person) {
            return $job->action === 'person_information_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated general information about '.$person->name;
        });

        Queue::assertPushed(UpdateUserLastActivityDate::class, function ($job) use ($user) {
            return $job->user->id === $user->id;
        });
    }

    #[Test]
    public function it_throws_exception_when_person_doesnt_belong_to_user_account(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $person = Person::factory()->create(['account_id' => $otherUser->account_id]);

        $this->expectException(ModelNotFoundException::class);

        $service = new UpdatePersonInformation(
            user: $user,
            person: $person,
            timezone: 'America/New_York',
            nationalities: 'American, Canadian',
            languages: 'English, French',
        );
        $service->execute();
    }
}
