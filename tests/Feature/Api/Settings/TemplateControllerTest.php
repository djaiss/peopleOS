<?php

namespace Tests\Feature\Api\Settings;

use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TemplateControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_template(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/templates', [
            'name' => 'Work day',
            'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
        ]);

        $response->assertStatus(201);
        $template = Template::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $template->id,
                'object' => 'template',
                'name' => 'Work day',
                'content' =>
                <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
        ]);
    }

    #[Test]
    public function it_updates_a_template(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Old template',
            'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/templates/' . $template->id, [
            'name' => 'New template',
            'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Updated Question"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
YAML,
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $template->id,
                'object' => 'template',
                'name' => 'New template',
                'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Updated Question"
          answers:
            type: "range"
            range: [1, 5]
            comment_allowed: true
YAML,
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
        ]);
    }

    #[Test]
    public function it_cant_update_a_template(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'name' => 'Old template',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/templates/' . $template->id, [
            'name' => 'New template',
            'content' => 'new: content',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_template(): void
    {
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Template to delete',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/templates/' . $template->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('templates', [
            'id' => $template->id,
        ]);
    }

    #[Test]
    public function it_cant_delete_a_template(): void
    {
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'name' => 'Template',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/templates/' . $template->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_a_template(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $template = Template::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Template',
            'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/templates/' . $template->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $template->id,
                'object' => 'template',
                'name' => 'Template',
                'content' => <<<'YAML'
template:
  name: "Daily Reflection"
  columns:
    - name: "General Overview"
      questions:
        - name: "Test Question"
          answers:
            type: "range"
            range: [1, 4]
            comment_allowed: false
YAML,
                'created_at' => '1514764800',
                'updated_at' => '1514764800',
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_lists_all_the_templates(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        Template::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Template',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/templates');

        $response->assertStatus(200);

        $this->assertEquals(
            1,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
