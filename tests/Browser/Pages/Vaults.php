<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Vaults extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/';
    }

    public function createVault(Browser $browser, string $name, string $description): void
    {
        $browser->click('@create-vault-no-vaults')
            ->type('name', $name)
            ->type('description', $description)
            ->click('@submit-form-button');
    }
}
