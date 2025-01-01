<?php

namespace Tests\Browser\Pages;

use App\Models\Contact;
use Laravel\Dusk\Page;

class ContactDetails extends Page
{
    protected Contact $contact;

    /**
     * Get the URL for the page.
     */
    public function url()
    {
        return '/vaults/' . $this->contact->vault_id . '/contacts/' . $this->contact->slug;
    }
}
