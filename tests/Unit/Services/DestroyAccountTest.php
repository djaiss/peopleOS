<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Mail\AccountDestroyed;
use App\Models\AccountDeletionReason;
use App\Models\User;
use App\Services\DestroyAccount;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyAccountTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_an_account(): void
    {
        Queue::fake();
        Mail::fake();
        config(['mail.account_deletion_notification_email' => 'regis@peopleos.com']);

        $user = User::factory()->create();

        (new DestroyAccount(
            user: $user,
            reason: 'the service is not working',
        ))->execute();

        $this->assertDatabaseMissing('accounts', [
            'id' => $user->account_id,
        ]);

        $this->assertEquals(
            'the service is not working',
            AccountDeletionReason::first()->reason,
        );

        Mail::assertQueued(AccountDestroyed::class, function (AccountDestroyed $job): bool {
            return $job->reason === 'the service is not working'
                && $job->to[0]['address'] === 'regis@peopleos.com';
        });
    }
}
