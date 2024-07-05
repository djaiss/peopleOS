<?php

namespace Tests\Browser\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class PreferencesTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_update_the_name_order_of_the_contacts(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/settings')
                ->click('@preferences-link')
                ->waitForRoute('settings.preferences.index')
                ->assertSee('%first_name% %last_name%')
                ->click('@edit-name-order')
                ->waitFor('@name-order-save-form-button')
                ->radio('name-order', '%last_name% %first_name%')
                ->click('@name-order-save-form-button')
                ->waitFor('@edit-name-order')
                ->assertSee('%last_name% %first_name%');
        });
    }
}
