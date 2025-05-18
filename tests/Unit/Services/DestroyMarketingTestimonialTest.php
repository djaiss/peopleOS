<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Services\DestroyMarketingTestimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyMarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_marketing_testimony(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
        ]);
        $testimonial = MarketingTestimonial::factory()->create([
            'account_id' => $user->account_id,
            'name_to_display' => 'Phoebe Buffay',
            'testimony' => 'Smelly Cat, what are they feeding you?',
        ]);

        (new DestroyMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
        ))->execute();

        $this->assertDatabaseMissing('marketing_testimonies', [
            'id' => $testimonial->id,
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
                return $job->action === 'marketing_testimonial_deletion'
                    && $job->user->id === $user->id
                    && $job->description === 'Deleted a marketing testimonial';
            },
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_in_the_same_account(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);
        $testimonial = MarketingTestimonial::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new DestroyMarketingTestimonial(
            user: $user,
            testimonial: $testimonial,
        ))->execute();
    }
}
