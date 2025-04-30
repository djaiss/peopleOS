<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\SendMarketingTestimonialReviewedEmail;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Services\ValidateMarketingTestimonial;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateMarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_a_marketing_testimonial_as_instance_administrator(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $ross = User::factory()->create([
            'email' => 'ross@geller.com',
        ]);
        $testimonial = MarketingTestimonial::factory()->create([
            'user_id' => $ross->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $updatedTestimonial = (new ValidateMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonialStatus::APPROVED->value,
        ]);

        $this->assertEquals(
            MarketingTestimonialStatus::APPROVED->value,
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
        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to validate a testimonial.');

        (new ValidateMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);
    }
}
