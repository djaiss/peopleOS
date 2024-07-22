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
 * All the information about a contact: name, job info, background info.
 */
final class ContactInformationCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'user.vaults.contact:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        protected readonly User $user,
        protected readonly Contact $contact,
    ) {
        $this->identifier = $user->id . '_' . $contact->id;
    }

    public static function make(User $user, Contact $contact): static
    {
        return new self($user, $contact);
    }

    protected function generate(): array
    {
        return ContactViewModel::show($this->contact);
    }
}
