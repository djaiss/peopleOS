<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateNote;
use App\Services\DestroyNote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyNoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_destroys_a_note(): void
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
        $this->executeService($user, $note);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $note);
    }

    #[Test]
    public function it_fails_if_user_doesnt_have_right_permission_in_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_VIEW, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $note);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
        ]);
        $this->executeService($user, $note);
    }

    #[Test]
    public function it_fails_if_note_doesnt_belong_to_contact(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create();
        $this->executeService($user, $note);
    }

    private function executeService(User $user, Note $note): void
    {
        (new DestroyNote(
            user: $user,
            note: $note,
        ))->execute();

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
    }
}
