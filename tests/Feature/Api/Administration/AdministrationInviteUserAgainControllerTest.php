<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationInviteUserAgainControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_send_new_invitation(): void
    {
        $user = User::factory()->create();

        $invitedUser = User::factory()->create([
            'account_id' => $user->account_id,
            'invitation_accepted_at' => null,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/administration/users/' . $invitedUser->id . '/invite');

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $invitedUser->id,
                'object' => 'user',
                'email' => $invitedUser->email,
            ],
            $response->json(),
        );
    }
}
