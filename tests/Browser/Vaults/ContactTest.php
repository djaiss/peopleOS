<?php

namespace Tests\Browser\Vaults;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\Browser\Pages\ContactDetails;
use Tests\DuskTestCase;

class ContactTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_create_a_contact(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('')
                ->click('@create-vault-no-vaults')
                ->type('name', 'Accounting')
                ->type('description', 'Accounting team')
                ->click('@submit-form-button')
                ->assertPathIs('/vaults/' . Vault::first()->id)
                ->click('@navigation-contact-link')
                ->click('@create-contact-button')
                ->type('first_name', 'John')
                ->type('last_name', 'Doe')
                ->click('@submit-form-button')
                ->assertPathIs('/vaults/' . Vault::first()->id . '/contacts/' . Contact::first()->slug);
        });
    }
}
