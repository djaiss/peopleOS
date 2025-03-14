<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationTimezoneControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_update_their_timezone(): void
    {
        $user = User::factory()->create([
            'timezone' => 'UTC',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/timezone', [
                'timezone' => 'America/New_York',
            ]);

        $response->assertRedirect('/administration');
        $response->assertSessionHas('status', 'Changes saved');

        $this->assertEquals('America/New_York', $user->timezone);
    }

    #[Test]
    public function timezone_is_required(): void
    {
        $user = User::factory()->create([
            'timezone' => 'UTC',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/timezone', [
                'timezone' => '',
            ]);

        $response->assertRedirect('/administration');
        $response->assertSessionHasErrors(['timezone' => 'The timezone field is required.']);

        $this->assertEquals('UTC', $user->timezone);
    }

    #[Test]
    public function timezone_must_be_a_string(): void
    {
        $user = User::factory()->create([
            'timezone' => 'UTC',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/timezone', [
                'timezone' => 123,
            ]);

        $response->assertRedirect('/administration');
        $response->assertSessionHasErrors(['timezone' => 'The timezone field must be a string.']);

        $this->assertEquals('UTC', $user->timezone);
    }

    #[Test]
    public function unauthenticated_user_cannot_update_timezone(): void
    {
        $response = $this->put('/administration/timezone', [
            'timezone' => 'America/New_York',
        ]);

        $response->assertRedirect('/login');
    }
}
