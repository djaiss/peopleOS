<?php

namespace Tests;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Create a vault.
     */
    public function createVault(User $user): Vault
    {
        $vault = Vault::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $vault->users()->save($user, [
            'contact_id' => $contact->id,
        ]);

        return $vault;
    }
}
