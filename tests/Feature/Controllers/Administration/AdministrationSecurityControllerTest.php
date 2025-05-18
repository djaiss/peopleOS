<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationSecurityControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_security_index_can_be_rendered(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $token = $user->createToken('Test Token');

        $response = $this->actingAs($user)
            ->get('/administration/security');

        $response->assertStatus(200);
        $response->assertViewIs('administration.security.index');
        $this->assertArrayHasKey('apiKeys', $response);

        $apiKeys = $response['apiKeys'];
        $this->assertCount(1, $apiKeys);
        $this->assertEquals('Test Token', $apiKeys[0]['name']);
    }

    #[Test]
    public function administration_security_new_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/security/new');

        $response->assertStatus(200);
        $response->assertViewIs('administration.security.partials.new');
    }

    #[Test]
    public function user_can_create_new_api_token(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/security/new')
            ->post('/administration/security', [
                'label' => 'My API Token',
            ]);

        $response->assertRedirect('/administration/security');
        $response->assertSessionHas('status', 'API key created');

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'My API Token',
            'tokenable_id' => $user->id,
        ]);
    }

    #[Test]
    public function user_cannot_create_token_without_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/security/new')
            ->post('/administration/security', [
                'label' => '',
            ]);

        $response->assertRedirect('/administration/security/new');
        $response->assertSessionHasErrors(['label' => 'The label field is required.']);
    }

    #[Test]
    public function user_can_delete_api_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token');

        $response = $this->actingAs($user)
            ->from('/administration/security')
            ->delete('/administration/security/' . $token->accessToken->id);

        $response->assertRedirect('/administration/security');
        $response->assertSessionHas('status', 'API key deleted');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
