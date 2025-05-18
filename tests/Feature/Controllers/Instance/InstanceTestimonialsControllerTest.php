<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Enums\MarketingTestimonialStatus;
use App\Models\MarketingTestimonial;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceTestimonialsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_pending_testimonials(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = User::factory()->create([
            'is_instance_admin' => true,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
            'name_to_display' => 'Chandler Bing',
            'testimony' => 'Could this product BE any better?',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials');

        $response->assertStatus(200);
        $response->assertViewIs('instance.testimonials.index');
        $response->assertViewHas('testimonials');
        $response->assertViewHas('title', __('Pending testimonials'));
        $response->assertViewHas('pending_testimonials_count', 1);
        $response->assertViewHas('approved_testimonials_count', 0);
        $response->assertViewHas('rejected_testimonials_count', 0);
        $response->assertViewHas('all_testimonials_count', 1);
    }

    #[Test]
    public function it_displays_approved_testimonials(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::APPROVED->value,
            'name_to_display' => 'Joey Tribbiani',
            'testimony' => 'How you doin\'? This product is amazing!',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials/approved');

        $response->assertStatus(200);
        $response->assertViewIs('instance.testimonials.index');
        $response->assertViewHas('testimonials');
        $response->assertViewHas('title', __('Approved testimonials'));
    }

    #[Test]
    public function it_displays_rejected_testimonials(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::REJECTED->value,
            'name_to_display' => 'Monica Geller',
            'testimony' => 'This product is not clean enough!',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials/rejected');

        $response->assertStatus(200);
        $response->assertViewIs('instance.testimonials.index');
        $response->assertViewHas('testimonials');
        $response->assertViewHas('title', __('Rejected testimonials'));
    }

    #[Test]
    public function it_displays_all_testimonials(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);
        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::APPROVED->value,
        ]);
        MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::REJECTED->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials/all');

        $response->assertStatus(200);
        $response->assertViewIs('instance.testimonials.index');
        $response->assertViewHas('testimonials');
        $response->assertViewHas('title', __('All testimonials'));
        $response->assertViewHas('all_testimonials_count', 3);
    }

    #[Test]
    public function it_accepts_a_testimonial(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $response = $this->actingAs($user)
            ->put('/instance/testimonials/' . $testimonial->id . '/accept');

        $response->assertRedirect();
        $response->assertSessionHas('status', __('Changes saved'));
    }

    #[Test]
    public function it_displays_reject_form(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials/' . $testimonial->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('instance.testimonials.partials.reject');
        $response->assertViewHas('testimonial', $testimonial);
    }

    #[Test]
    public function it_rejects_a_testimonial(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
        ]);

        $response = $this->actingAs($user)
            ->put('/instance/testimonials/' . $testimonial->id . '/reject', [
                'reason' => 'Not appropriate content',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', __('Changes saved'));
    }

    #[Test]
    public function it_requires_instance_admin_access(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials');

        $response->assertStatus(403);
    }

    #[Test]
    public function it_formats_testimonial_data_correctly(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = User::factory()->create([
            'is_instance_admin' => true,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $testimonial = MarketingTestimonial::factory()->create([
            'status' => MarketingTestimonialStatus::PENDING->value,
            'name_to_display' => 'Phoebe Buffay',
            'testimony' => 'This product is so good, it\'s like a cat!',
            'url_to_point_to' => 'https://example.com',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/testimonials');

        $response->assertStatus(200);
        $testimonials = $response['testimonials'];
        $this->assertCount(1, $testimonials);

        $this->assertEquals([
            'id' => $testimonial->id,
            'account_id' => $testimonial->account_id,
            'status' => $testimonial->status,
            'user' => [
                'id' => $testimonial->user->id,
                'name' => $testimonial->user->name,
            ],
            'name_to_display' => $testimonial->name_to_display,
            'url_to_point_to' => $testimonial->url_to_point_to,
            'testimony' => $testimonial->testimony,
            'created_at' => '2018-01-01 00:00:00',
        ], $testimonials[0]);
    }
}
