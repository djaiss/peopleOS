<?php

namespace Tests\Browser\Vaults;

use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class ContactNoteTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_create_a_note(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'permission' => Vault::PERMISSION_MANAGE,
            'contact_id' => $contact->id,
        ]);

        $this->browse(function (Browser $browser) use ($user, $vault, $contact): void {
            $browser->loginAs($user)
                ->visit('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
                ->type('@note-body', 'this is a note')
                ->click('@submit-note')
                ->pause(130)
                ->assertSeeIn('@note-body-' . Note::latest()->first()->id, 'this is a note');
        });
    }

    #[Test]
    public function a_user_can_edit_a_note(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'permission' => Vault::PERMISSION_MANAGE,
            'contact_id' => $contact->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
            'body' => 'this is a note',
        ]);

        $this->browse(function (Browser $browser) use ($user, $vault, $contact, $note): void {
            $browser->loginAs($user)
                ->visit('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
                ->mouseover('#note-' . $note->id)
                ->click('@edit-cta-note-' . $note->id)
                ->type('@update-note-body-' . $note->id, 'this is a great note')
                ->click('@update-note-' . $note->id)
                ->pause(130)
                ->assertSeeIn('@note-body-' . $note->id, 'this is a great note');
        });
    }

    #[Test]
    public function a_user_can_delete_a_note(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'permission' => Vault::PERMISSION_MANAGE,
            'contact_id' => $contact->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
            'body' => 'this is a great note',
        ]);

        $this->browse(function (Browser $browser) use ($user, $vault, $contact, $note): void {
            $browser->loginAs($user)
                ->visit('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
                ->mouseover('#note-' . $note->id)
                ->click('@delete-note-' . $note->id)
                ->acceptDialog()
                ->pause(130)
                ->assertDontSee('this is a great note');
        });
    }
}
