<?php

namespace Tests\Feature\Controllers\Settings;

use App\Models\Template;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsTemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_lets_the_user_see_his_templates(): void
    {
        $user = User::factory()->create();
        Template::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Work day',
        ]);

        $response = $this->actingAs($user)
            ->get('/settings/templates')
            ->assertSee('Work day');

        $this->assertArrayHasKey('templates', $response);
        $this->assertArrayHasKey('routes', $response);

        $this->assertEquals(
            env('APP_URL') . '/settings/templates/new',
            $response['routes']['template']['new']
        );
    }

    #[Test]
    public function a_user_sees_an_empty_screen_where_there_is_no_template_yet(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/settings/templates')
            ->assertStatus(200)
            ->assertSee('blank-state')
            ->assertSee('Templates are used to structure your journal entries.');

        $this->assertArrayHasKey('templates', $response->original);
        $this->assertArrayHasKey('routes', $response->original);

        $this->assertEquals(
            0,
            count($response->original['templates'])
        );
        $this->assertEquals(
            env('APP_URL') . '/settings/templates/new',
            $response->original['routes']['template']['new']
        );
    }
}
