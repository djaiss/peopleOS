<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use App\Services\CreateGender;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_gender(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $gender = (new CreateGender(
            user: $user,
            name: 'Male',
        ))->execute();

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $user->account_id,
            'position' => 1,
        ]);

        $this->assertEquals('Male', $gender->name);

        $this->assertInstanceOf(
            Gender::class,
            $gender
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

        $gender = (new CreateGender(
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
