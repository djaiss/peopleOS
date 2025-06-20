<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonialStatus;
use App\Jobs\LogUserAction;
use App\Jobs\SendMarketingTestimonialSubmittedEmail;
use App\Jobs\SendMarketingTestimonialSubmittedEmailToInstanceAdministrator;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\MarketingTestimonial;
use App\Models\User;
use App\Services\CreateMarketingTestimonial;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateMarketingTestimonialTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_marketing_testimonial(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $testimony = (new CreateMarketingTestimonial(
            user: $user,
            nameToDisplay: 'Joey Tribbiani',
            testimony: 'How you doin\'? This product is amazing!',
            urlToPointTo: 'https://joeydoesntsharefood.com',
            displayAvatar: true,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimony->id,
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'status' => MarketingTestimonialStatus::PENDING->value,
            'display_avatar' => true,
        ]);

        $this->assertEquals('Joey Tribbiani', $testimony->name_to_display);
        $this->assertEquals('https://joeydoesntsharefood.com', $testimony->url_to_point_to);
        $this->assertEquals('How you doin\'? This product is amazing!', $testimony->testimony);

        $this->assertInstanceOf(
            MarketingTestimonial::class,
            $testimony,
        );

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
                return $job->action === 'marketing_testimony_creation'
                    && $job->user->id === $user->id
                    && $job->description === 'Created a marketing testimony';
            },
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendMarketingTestimonialSubmittedEmail::class,
            callback: function (SendMarketingTestimonialSubmittedEmail $job) use ($user): bool {
                return $job->email === $user->email;
            },
        );

        Queue::assertPushedOn(
            queue: 'high',
            job: SendMarketingTestimonialSubmittedEmailToInstanceAdministrator::class,
        );
    }
}
