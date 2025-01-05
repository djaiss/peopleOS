<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
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

        $this->executeService($user);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function (UpdateUserLastActivityDate $job) use ($user): bool {
            return $job->user->id === $user->id;
        });

        Queue::assertPushed(LogUserAction::class, function (LogUserAction $job) use ($user): bool {
            return $job->action === 'api_key_creation' && $job->user->id === $user->id;
        });
    }

    private function executeService(User $user): void
    {
        (new CreateApiKey(
            user: $user,
            label: 'Test API Key',
        ))->execute();

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'Test API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }
}
