<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Services\UpdateMarketingTestimonial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateMarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_a_marketing_testimony(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $testimonial = MarketingTestimonial::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
            'name_to_display' => 'Monica Geller',
            'testimony' => 'I love how clean and organized this product is!',
            'url_to_point_to' => 'https://cleanliness-is-next-to-godliness.com',
            'display_avatar' => true,
        ]);

        $updatedTestimonial = (new UpdateMarketingTestimonial(
            user: $user,
            testimonialObject: $testimonial,
            nameToDisplay: 'Monica Geller-Bing',
            testimony: 'I am so freakishly organized, and this product helps me stay that way!',
            urlToPointTo: 'https://monica-cleaning-tips.com',
            displayAvatar: false,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimonial->id,
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
            'display_avatar' => false,
        ]);

        $this->assertEquals('Monica Geller-Bing', $updatedTestimonial->name_to_display);
        $this->assertEquals('https://monica-cleaning-tips.com', $updatedTestimonial->url_to_point_to);
        $this->assertEquals(
            'I am so freakishly organized, and this product helps me stay that way!',
            $updatedTestimonial->testimony
        );

        $this->assertInstanceOf(
            MarketingTestimonial::class,
            $updatedTestimonial
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: UpdateUserLastActivityDate::class,
            callback: function (UpdateUserLastActivityDate $job) use ($user): bool {
                return $job->user->id === $user->id;
            }
        );

        Queue::assertPushedOn(
            queue: 'low',
            job: LogUserAction::class,
            callback: function (LogUserAction $job) use ($user): bool {
                return $job->action === 'marketing_testimonial_update'
                    && $job->user->id === $user->id
                    && $job->description === 'Updated a marketing testimonial';
            }
        );
    }

    #[Test]
    public function it_fails_if_user_and_testimony_are_not_in_the_same_account(): void
    {
        $user = User::factory()->create();
        $testimonial = MarketingTestimonial::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        (new UpdateMarketingTestimonial(
            user: $user,
            testimonialObject: $testimonial,
            nameToDisplay: 'Chandler Bing',
            testimony: 'Could this product BE any better?',
        ))->execute();
    }
}
