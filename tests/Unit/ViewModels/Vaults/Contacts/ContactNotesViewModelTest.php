<?php

namespace Tests\Unit\ViewModels\Vaults\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactNotesViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_notes(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'John',
        ]);
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $note = Note::factory()->create([
            'contact_id' => $contact->id,
            'user_id' => $user->id,
            'body' => 'This is a note',
        ]);

        $collection = ContactNotesViewModel::index($contact);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            [
                'id' => $note->id,
                'body' => (string) Str::of('This is a note')->markdown(),
                'created_at' => 'January 01, 2018 (Monday)',
                'created_at_full_timestamp' => '2018-01-01 00:00:00',
                'user' => [
                    'id' => $user->id,
                    'name' => 'John',
                ],
            ],
            $collection->toArray()[0]
        );
    }
}
