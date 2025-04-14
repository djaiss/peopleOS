<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\SendAPICreatedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\CreateApiKey;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateApiKeyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_an_api_key(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        (new CreateApiKey(
            user: $user,
            label: 'Test API Key',
        ))->execute();

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'Test API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
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
                return $job->action === 'api_key_creation' && $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendAPICreatedEmail::class,
            callback: function (SendAPICreatedEmail $job) use ($user): bool {
                return $job->email === $user->email && $job->label === 'Test API Key';
            }
        );
    }
}
