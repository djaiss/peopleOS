<?php

namespace Tests\Browser\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    use DatabaseTruncation;

    #[Test]
    public function a_user_can_update_his_personal_information(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/settings')
                ->click('@profile-link')
                ->waitForRoute('settings.profile.index')
                ->type('first_name', 'Dwight')
                ->type('last_name', 'Schrute')
                ->type('email', 'dwight@dundermifflin.com')
                ->click('@profile-submit-form-button')
                ->assertPathIs('/verify-email');
        });
    }

    #[Test]
    public function a_user_can_update_his_password(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user): void {
            $browser->loginAs($user)
                ->visit('/settings')
                ->click('@profile-link')
                ->waitForRoute('settings.profile.index')
                ->type('current_password', 'password')
                ->type('password', 'new-password')
                ->type('password_confirmation', 'new-password')
                ->click('@password-submit-form-button')
                ->assertSee('Changes saved');
        });
    }
}
