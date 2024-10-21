<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use App\Services\CreateNote;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateNoteTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_creates_a_note(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user->account);
        $vault = $this->setPermissionInVault($user, Vault::PERMISSION_MANAGE, $vault);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $vault, $contact);
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
        $this->executeService($user, $vault, $contact);
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
        $this->executeService($user, $vault, $contact);
    }

    private function executeService(User $user, Vault $vault, Contact $contact): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $note = (new CreateNote(
            user: $user,
            contact: $contact,
            body: 'This is awesome',
        ))->execute();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'contact_id' => $contact->id,
        ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'updated_at' => '2018-01-01 00:00:00',
        ]);

        $this->assertInstanceOf(
            Note::class,
            $note
        );

        $this->assertEquals(
            'This is awesome',
            $note->body
        );
    }
}
