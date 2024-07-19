<?php

namespace Tests\Browser\Vaults;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class ContactTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_create_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'permission' => Vault::PERMISSION_EDIT,
            'contact_id' => $contact->id,
        ]);

        $this->browse(function (Browser $browser) use ($user, $vault): void {
            $browser->loginAs($user)
                ->visit('/vaults/'.$vault->id)
                ->click('@navigation-contact-link')
                ->click('@create-contact-button')
                ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->click('@submit-form-button')
                ->assertSee('John Doe');
        });
    }

    #[Test]
    public function a_user_can_add_background_information_to_a_contact(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'permission' => Vault::PERMISSION_EDIT,
            'contact_id' => $contact->id,
        ]);

        $this->browse(function (Browser $browser) use ($user, $vault, $contact): void {
            $browser->loginAs($user)
                ->visit('/vaults/' . $vault->id . '/contacts/' . $contact->slug)
                ->click('@blank-background-information')
                ->type('information', 'this is a background information')
                ->click('@update-background-information')
                ->pause(100)
                ->assertSeeIn('@background-information', 'this is a background information');
        });
    }
}
