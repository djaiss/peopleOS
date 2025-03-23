<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Mail\ApiKeyDestroyed;
use App\Models\User;
use App\Services\DestroyApiKey;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
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
        Mail::fake();

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

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'api_key_deletion' && $job->user->id === $user->id;
        });

        Mail::assertQueued(ApiKeyDestroyed::class, function (ApiKeyDestroyed $job): bool {
            return $job->label === 'Test API Key';
        });

        $this->assertDatabaseHas('accounts', [
            'id' => $user->account_id,
            'emails_sent' => 1,
        ]);
    }
}
