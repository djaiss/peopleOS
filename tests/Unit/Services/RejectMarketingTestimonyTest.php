<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Jobs\SendMarketingTestimonialRejectedEmail;
use App\Models\MarketingTestimony;
use App\Models\User;
use App\Services\RejectMarketingTestimony;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RejectMarketingTestimonyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_rejects_a_marketing_testimony_as_instance_administrator(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $testimony = MarketingTestimony::factory()->create([
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $updatedTestimony = (new RejectMarketingTestimony(
            user: $user,
            testimony: $testimony,
            reason: 'violent content',
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimony->id,
            'status' => MarketingTestimonyStatus::REJECTED->value,
        ]);

        $this->assertEquals(
            MarketingTestimonyStatus::REJECTED->value,
            $updatedTestimony->status
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendMarketingTestimonialRejectedEmail::class,
            callback: function (SendMarketingTestimonialRejectedEmail $job) use ($user): bool {
                return $job->email === $user->email;
            }
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
            'first_name' => 'Gunther',
        ]);
        $testimony = MarketingTestimony::factory()->create([
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to reject a testimony.');

        (new RejectMarketingTestimony(
            user: $user,
            testimony: $testimony,
            reason: 'violent content',
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimony->id,
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);
    }
}
