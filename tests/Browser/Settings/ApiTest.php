<?php

namespace Tests\Browser\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class ApiTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_manage_api_keys(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/settings')
                ->click('@api-link')
                ->waitForRoute('settings.api.index')
                ->assertSee('There are no API keys defined at the moment')
                ->click('@add-key')
                ->waitFor('@submit-form-button')
                ->type('token_name', 'Dunder Mifflin Infinity')
                ->click('@submit-form-button')
                ->waitFor('@add-key')
                ->assertSee('Dunder Mifflin Infinity');

            // delete api key
            $id = DB::table('personal_access_tokens')->where('name', 'Dunder Mifflin Infinity')->first()->id;

            $browser->click('@cta-revoke-key-'.$id)
                ->acceptDialog()
                ->pause(120)
                ->assertDontSee('Dunder Mifflin Infinity');
        });
    }
}
