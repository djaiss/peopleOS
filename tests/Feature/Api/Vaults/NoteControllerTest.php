<?php

namespace Tests\Feature\Api\Vaults;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_note(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes', [
            'body' => 'This is a note.',
        ]);

        $response->assertStatus(201);
        $note = Note::orderBy('id', 'desc')->first();

        $this->assertEquals(
            [
                'id' => $note->id,
                'object' => 'note',
                'body' => 'This is a note.',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_updates_a_note(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes/'.$note->id, [
            'body' => 'This is an updated note.',
        ]);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'id' => $note->id,
                'object' => 'note',
                'body' => 'This is an updated note.',
                'contact' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                ],
                'created_at' => 1514764800,
                'updated_at' => 1514764800,
            ],
            $response->json()['data']
        );
    }

    #[Test]
    public function it_cant_update_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes/'.$note->id, [
            'body' => 'This is an updated note.',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_deletes_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes/'.$note->id);

        $response->assertStatus(200);

        $this->assertEquals(
            [
                'status' => 'success',
            ],
            $response->json()
        );
    }

    #[Test]
    public function it_cant_delete_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes/'.$note->id);

        $response->assertStatus(401);
    }

    #[Test]
    public function it_lists_all_the_notes(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        Note::factory()->count(2)->create([
            'contact_id' => $contact->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/vaults/'.$vault->id.'/contacts/'.$contact->id.'/notes');

        $response->assertStatus(200);

        $this->assertEquals(
            2,
            count($response->json()['data'])
        );
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
    }
}
