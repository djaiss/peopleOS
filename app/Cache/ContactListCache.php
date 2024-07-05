<?php

namespace App\Cache;

use App\Helpers\CacheHelper;
use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Models\User;
use App\Models\Vault;
use App\Traits\CacheIdentifier;
use Illuminate\Support\Collection;

/**
 * All the contacts of the vault, for the given user.
 */
final class ContactListCache extends CacheHelper
{
    use CacheIdentifier;

    protected string $key = 'user.vaults.contacts:%s';

    protected int $ttl = 604800; // 1 week

    public function __construct(
        protected readonly User $user,
        protected readonly Vault $vault,
    ) {
        $this->identifier = $user->id.'_'.$vault->id;
    }

    public static function make(User $user, Vault $vault): static
    {
        return new self($user, $vault);
    }

    protected function generate(): Collection
    {
        return ContactViewModel::index($this->vault);
    }
}
