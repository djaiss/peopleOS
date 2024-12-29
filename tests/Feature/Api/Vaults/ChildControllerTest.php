<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Child;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ChildControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_child(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children', [
            'gender' => 'boy',
            'name' => 'John Doe',
            'age' => 10,
            'grade_level' => '10th',
            'school' => 'Saint Junior High School',
        ]);

        $response->assertStatus(201);
        $child = Child::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $child->id,
                'object' => 'child',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'gender' => 'boy',
                'name' => 'John Doe',
                'age' => 10,
                'grade_level' => '10th',
                'school' => 'Saint Junior High School',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('children', [
            'id' => $child->id,
        ]);
    }

    #[Test]
    public function it_updates_a_child(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children/'.$child->id, [
            'gender' => 'girl',
            'name' => 'Jane Doe',
            'age' => 10,
            'grade_level' => '10th',
            'school' => 'Saint Junior High School',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $child->id,
                'object' => 'child',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'gender' => 'girl',
                'name' => 'Jane Doe',
                'age' => 10,
                'grade_level' => '10th',
                'school' => 'Saint Junior High School',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );

        $this->assertDatabaseHas('children', [
            'id' => $child->id,
        ]);
    }

    #[Test]
    public function it_cant_update_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children/'.$child->id, [
            'gender' => 'girl',
            'name' => 'Jane Doe',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children/'.$child->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );

        $this->assertDatabaseMissing('children', [
            'id' => $child->id,
        ]);
    }

    #[Test]
    public function it_cant_delete_a_child(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children/'.$child->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_shows_a_child(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
            'gender' => 'boy',
            'name' => 'John Doe',
            'age' => 10,
            'grade_level' => '10th',
            'school' => 'Saint Junior High School',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children/'.$child->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $child->id,
                'object' => 'child',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'gender' => 'boy',
                'name' => 'John Doe',
                'age' => 10,
                'grade_level' => '10th',
                'school' => 'Saint Junior High School',
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_lists_all_the_children(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        Child::factory()->count(2)->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/children');

        $response->assertStatus(200);

        $this->assertEquals(
            2,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
