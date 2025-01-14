<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use App\Services\UpdateGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_gender(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);

        $updatedGender = (new UpdateGender(
            user: $user,
            gender: $gender,
            name: 'Female',
            position: 2,
        ))->execute();

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
            'account_id' => $user->account_id,
            'position' => 2,
        ]);

        $this->assertEquals('Female', $updatedGender->name);

        $this->assertInstanceOf(
            Gender::class,
            $updatedGender
        );

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'gender_update'
                && $job->user->id === $user->id
                && $job->description === 'Updated the gender called Female';
        });
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateGender(
            user: $user,
            gender: $gender,
            name: 'Female',
            position: 2,
        ))->execute();
    }
}
