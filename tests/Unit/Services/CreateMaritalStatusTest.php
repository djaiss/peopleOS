<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use App\Services\CreateMaritalStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateMaritalStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_marital_status(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $maritalStatus = (new CreateMaritalStatus(
            user: $user,
            name: 'Married',
        ))->execute();

        $this->assertDatabaseHas('marital_statuses', [
            'id' => $maritalStatus->id,
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $this->assertEquals('Married', $maritalStatus->name);

        $this->assertInstanceOf(
            MaritalStatus::class,
            $maritalStatus
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'gender_creation'
                && $job->user->id === $user->id
                && $job->description === 'Created the gender called Male';
        });
    }

    #[Test]
    public function it_makes_sure_the_gender_is_created_in_the_correct_position(): void
    {
        $user = User::factory()->create();
        Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        $gender = (new CreateMaritalStatus(
            user: $user,
            name: 'Female',
        ))->execute();

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $user->account_id,
            'position' => 2,
        ]);
    }
}
