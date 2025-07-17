<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\User;
use App\Services\Generate2faQRCode;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use PragmaRX\Google2FALaravel\Google2FA;
use Tests\TestCase;

class Generate2faQRCodeTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_generates_2fa_qr_code(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-07-16 10:00:00'));

        Queue::fake();

        $user = User::factory()->create([
            'email' => 'chandler.bing@example.com',
        ]);

        $result = (new Generate2faQRCode(
            user: $user,
        ))->execute();

        $this->assertIsString($result['secret']);

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
                return $job->user->id === $user->id &&
                    $job->action === '2fa_qr_code_generation' &&
                    $job->description === 'Generated 2FA QR code for setup';
            },
        );
    }
}
