<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationUserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_invite_a_user(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/users', [
            'email' => 'dwight.schrute@dundermifflin.com',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => User::where('email', 'dwight.schrute@dundermifflin.com')->first()->id,
                'object' => 'user',
                'email' => 'dwight.schrute@dundermifflin.com',
            ],
            $response->json()
        );

        $this->assertDatabaseHas('users', [
            'email' => 'dwight.schrute@dundermifflin.com',
            'account_id' => $user->account_id,
        ]);
    }

    #[Test]
    public function it_validates_email_when_inviting_user(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/administration/users', [
            'email' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);

        $response = $this->json('POST', '/api/administration/users', [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);

        $response = $this->json('POST', '/api/administration/users', [
            'email' => str_repeat('a', 256).'@test.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
