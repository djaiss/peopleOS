<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Instance;

use App\Enums\UserWaitlistStatus;
use App\Models\User;
use App\Models\UserWaitlist;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstanceWaitlistControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_subscribed_and_confirmed_entries(): void
    {
        Carbon::setTestNow(Carbon::create(2024, 3, 17, 10, 0, 0));

        $user = User::factory()->create([
            'is_instance_admin' => true,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $waitlistEntry = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
            'email' => 'chandler@friends.com',
            'confirmed_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist');

        $response->assertStatus(200);
        $response->assertViewIs('instance.waitlist.index');
        $response->assertViewHas('waitlist_entries');
        $response->assertViewHas('title', __('Subscribed and confirmed'));
        $response->assertViewHas('subscribed_and_confirmed_count', 1);
        $response->assertViewHas('subscribed_not_confirmed_count', 0);
        $response->assertViewHas('approved_count', 0);
        $response->assertViewHas('rejected_count', 0);
        $response->assertViewHas('all_count', 1);
    }

    #[Test]
    public function it_displays_subscribed_not_confirmed_entries(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'email' => 'joey@friends.com',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist/not-confirmed');

        $response->assertStatus(200);
        $response->assertViewIs('instance.waitlist.index');
        $response->assertViewHas('waitlist_entries');
        $response->assertViewHas('title', __('Subscribed but not confirmed'));
    }

    #[Test]
    public function it_displays_approved_entries(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::APPROVED->value,
            'email' => 'monica@friends.com',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist/approved');

        $response->assertStatus(200);
        $response->assertViewIs('instance.waitlist.index');
        $response->assertViewHas('waitlist_entries');
        $response->assertViewHas('title', __('Approved waitlist entries'));
    }

    #[Test]
    public function it_displays_rejected_entries(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::REJECTED->value,
            'email' => 'phoebe@friends.com',
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist/rejected');

        $response->assertStatus(200);
        $response->assertViewIs('instance.waitlist.index');
        $response->assertViewHas('waitlist_entries');
        $response->assertViewHas('title', __('Rejected waitlist entries'));
    }

    #[Test]
    public function it_displays_all_entries(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
        ]);
        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
        ]);
        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::APPROVED->value,
        ]);
        UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::REJECTED->value,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist/all');

        $response->assertStatus(200);
        $response->assertViewIs('instance.waitlist.index');
        $response->assertViewHas('waitlist_entries');
        $response->assertViewHas('title', __('All waitlist entries'));
        $response->assertViewHas('all_count', 4);
    }

    #[Test]
    public function it_requires_instance_admin_access(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist');

        $response->assertStatus(403);
    }

    #[Test]
    public function it_formats_waitlist_data_correctly(): void
    {
        Carbon::setTestNow(Carbon::create(2024, 3, 17, 10, 0, 0));

        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $waitlistEntry = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_AND_CONFIRMED->value,
            'email' => 'rachel@friends.com',
            'confirmed_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->get('/instance/waitlist');

        $response->assertStatus(200);
        $waitlistEntries = $response['waitlist_entries'];
        $this->assertCount(1, $waitlistEntries);

        $this->assertEquals(
            [
                'id' => $waitlistEntry->id,
                'email' => $waitlistEntry->email,
                'status' => $waitlistEntry->status,
                'created_at' => '2024-03-17 10:00:00',
                'confirmed_at' => '2024-03-17 10:00:00',
            ],
            $waitlistEntries[0]
        );
    }

    #[Test]
    public function it_accepts_a_user_in_the_waitlist(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'email' => 'rachel@friends.com',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->put('/instance/waitlist/'.$waitlist->id.'/approve');

        $response->assertRedirect();
        $response->assertSessionHas('status', __('Changes saved'));
    }

    #[Test]
    public function it_rejects_a_user_in_the_waitlist(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);

        $waitlist = UserWaitlist::factory()->create([
            'status' => UserWaitlistStatus::SUBSCRIBED_NOT_CONFIRMED->value,
            'email' => 'rachel@friends.com',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->put('/instance/waitlist/'.$waitlist->id.'/reject');

        $response->assertRedirect();
        $response->assertSessionHas('status', __('Changes saved'));
    }
}
