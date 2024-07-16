<?php

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * All the notes of the contact.
 */
final class ContactNoteCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'user.vaults.contacts.notes:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        protected readonly Contact $contact,
    ) {
        $this->identifier = $contact->id;
    }

    public static function make(Contact $contact): static
    {
        return new self($contact);
    }

    protected function generate(): Collection
    {
        return ContactNotesViewModel::index($this->contact);
    }
}
