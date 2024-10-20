<?php

namespace Tests\Feature\Controllers\Vaults\Contacts;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_create_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $this->actingAs($user)
            ->post('/vaults/' . $vault->id . '/contacts/' . $contact->slug . '/notes', [
                'body' => 'This is a note',
            ])
            ->assertSee('This is a note');

        $this->actingAs($user)
            ->get('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
            ->assertSee('This is a note');
    }

    #[Test]
    public function a_user_can_edit_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
            'body' => 'This is a note',
        ]);

        $this->actingAs($user)
            ->put('/vaults/' . $vault->id . '/contacts/' . $contact->slug . '/notes/' . $note->id, [
                'body' => 'This is a super note',
            ])
            ->assertSee('This is a super note');

        $this->actingAs($user)
            ->get('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
            ->assertSee('This is a super note');
    }

    #[Test]
    public function a_user_can_destroy_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
            'body' => 'This is a note',
        ]);

        $this->actingAs($user)
            ->delete('/vaults/' . $vault->id . '/contacts/' . $contact->slug . '/notes/' . $note->id)
            ->assertDontSee('This is a note');
    }
}
