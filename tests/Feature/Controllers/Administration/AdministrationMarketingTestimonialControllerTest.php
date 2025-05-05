<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\MarketingTestimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationMarketingTestimonialControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_loads_the_new_testimonial_view(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/marketing');

        $response->assertOk();
    }

    #[Test]
    public function it_can_create_a_testimonial(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/marketing/testimonials/new')
            ->post('/administration/marketing/testimonials', [
                'name' => 'Joey Tribbiani',
                'testimony' => 'How you doin\'? This product is amazing!',
                'url_to_point_to' => 'https://example.com',
            ]);

        $response->assertRedirect('/administration/marketing');
        $response->assertSessionHas('status', __('Changes saved'));
    }

    #[Test]
    public function it_loads_the_edit_testimonial_view(): void
    {
        $user = User::factory()->create();
        $testimonial = MarketingTestimonial::factory()->create([
            'account_id' => $user->account_id,
            'name_to_display' => 'Chandler Bing',
            'testimony' => 'Could this product BE any better?',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/marketing/testimonials/'.$testimonial->id.'/edit');

        $response->assertOk();
        $response->assertViewIs('administration.marketing.partials.edit-testimony');
        $response->assertViewHas('testimonial', $testimonial);
    }

    #[Test]
    public function it_can_edit_a_testimonial(): void
    {
        $user = User::factory()->create();
        $testimonial = MarketingTestimonial::factory()->create([
            'account_id' => $user->account_id,
            'name_to_display' => 'Chandler Bing',
            'testimony' => 'Could this product BE any better?',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/marketing/testimonials/'.$testimonial->id.'/edit')
            ->put('/administration/marketing/testimonials/'.$testimonial->id, [
                'name' => 'Joey Tribbiani',
                'testimony' => 'How you doin\'? This product is amazing!',
                'url_to_point_to' => 'https://example.com',
            ]);

        $response->assertRedirect('/administration/marketing');
        $response->assertSessionHas('status', __('Changes saved'));
    }

    #[Test]
    public function it_can_delete_a_testimonial(): void
    {
        $user = User::factory()->create();
        $testimonial = MarketingTestimonial::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/marketing')
            ->delete('/administration/marketing/testimonials/'.$testimonial->id);

        $response->assertRedirect('/administration/marketing');
        $response->assertSessionHas('status', __('Changes saved'));
    }
}
