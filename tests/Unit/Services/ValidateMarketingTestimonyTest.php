<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Jobs\SendMarketingTestimonialReviewedEmail;
use App\Models\MarketingTestimony;
use App\Models\User;
use App\Services\ValidateMarketingTestimony;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateMarketingTestimonyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_a_marketing_testimony_as_instance_administrator(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $ross = User::factory()->create([
            'email' => 'ross@geller.com',
        ]);
        $testimonial = MarketingTestimony::factory()->create([
            'user_id' => $ross->id,
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $updatedTestimonial = (new ValidateMarketingTestimony(
            user: $user,
            testimonial: $testimonial,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonyStatus::APPROVED->value,
        ]);

        $this->assertEquals(
            MarketingTestimonyStatus::APPROVED->value,
            $updatedTestimonial->status
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendMarketingTestimonialReviewedEmail::class,
            callback: function (SendMarketingTestimonialReviewedEmail $job): bool {
                return $job->email === 'ross@geller.com';
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
        $testimonial = MarketingTestimony::factory()->create([
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to validate a testimonial.');

        (new ValidateMarketingTestimony(
            user: $user,
            testimonial: $testimonial,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);
    }
}
