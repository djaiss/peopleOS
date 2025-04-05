<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Gender;
use App\Models\User;
use App\Services\DestroyGender;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyGenderTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_gender(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        (new DestroyGender(
            user: $user,
            gender: $gender,
        ))->execute();

        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'gender_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted the gender called Male';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyGender(
            user: $user,
            gender: $gender,
        ))->execute();
    }
}
