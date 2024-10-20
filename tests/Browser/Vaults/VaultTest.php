<?php

namespace Tests\Browser\Vaults;

use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class VaultTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_manage_a_vault(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('')
                ->click('@create-vault-no-vaults')
                ->type('name', 'Accounting')
                ->type('description', 'Accounting team')
                ->click('@submit-form-button')
                ->assertPathIs('/vaults/' . Vault::first()->id);

            $browser->visit('/vaults/' . Vault::first()->id . '/settings')
                ->click('@delete-vault-cta')
                ->acceptDialog()
                ->assertPathIs('/');
        });
    }
}
