<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\SendAPIDestroyedEmail;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\DestroyApiKey;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyApiKeyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_deletes_an_api_key(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $user->createToken('Test API Key');

        $tokenId = $user->tokens()->first()->id;

        (new DestroyApiKey(
            user: $user,
            tokenId: $tokenId,
        ))->execute();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $tokenId,
        ]);

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'api_key_deletion' && $job->user->id === $user->id;
            },
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendAPIDestroyedEmail::class,
            callback: function (SendAPIDestroyedEmail $job) use ($user): bool {
                return $job->email === $user->email && $job->label === 'Test API Key';
            },
        );
    }
}
