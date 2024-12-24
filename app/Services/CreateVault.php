<?php

namespace App\Services;

use App\Cache\AccountVaultsCache;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Support\Str;

class CreateVault
{
    private Vault $vault;

    private Contact $contact;

    public function __construct(
        public User $user,
        public string $name,
        public ?string $description,
    ) {
    }

    public function execute(): Vault
    {
        $this->create();
        $this->createUserContact();
        $this->associateUserToVault();
        $this->clearCache();

        return $this->vault;
    }

    private function create(): void
    {
        $this->vault = Vault::create([
            'account_id' => $this->user->account_id,
            'name' => $this->name,
            'description' => $this->description ?? null,
        ]);
    }

    private function createUserContact(): void
    {
        $this->contact = Contact::create([
            'vault_id' => $this->vault->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'can_be_deleted' => false,
        ]);

        $name = $this->contact->first_name . ' ' . $this->contact->last_name;
        $slug = $this->contact->id . '-' . Str::of($name)->slug('-');

        $this->contact->slug = $slug;
        $this->contact->save();
    }

    private function associateUserToVault(): void
    {
        $this->vault->users()->save($this->user, [
            'contact_id' => $this->contact->id,
        ]);
    }

    private function clearCache(): void
    {
        AccountVaultsCache::make(
            account: $this->user->account,
        )->refresh();
    }
}
