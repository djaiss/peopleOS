<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\SendMarketingTestimonialRejectedEmail;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Services\RejectMarketingTestimonial;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RejectMarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_rejects_a_marketing_testimonial_as_instance_administrator(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $updatedTestimonial = (new RejectMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
            reason: 'violent content',
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonialStatus::REJECTED->value,
        ]);

        $this->assertEquals(
            MarketingTestimonialStatus::REJECTED->value,
            $updatedTestimonial->status
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
        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to reject a testimonial.');

        (new RejectMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
            reason: 'violent content',
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);
    }
}
