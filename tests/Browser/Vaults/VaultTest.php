<?php

namespace Tests\Browser\Vaults;

use App\Models\Channel;
use App\Models\Topic;
use App\Models\User;
use App\Models\Vault;
use DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;

class VaultTest extends DuskTestCase
{
    #[Test]
    public function a_user_can_create_a_vault(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('')
                ->click('@create-vault-no-vaults')
                ->type('name', 'Accounting')
                ->type('description', 'Accounting team')
                ->click('@submit-form-button')
                ->assertPathIs('/')
                ->assertSee('Accounting');
        });
    }
}
