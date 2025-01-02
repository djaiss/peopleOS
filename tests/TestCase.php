<?php

declare(strict_types=1);

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
    final public function createVault(User $user, string $firstName = 'Dwight', string $lastName = 'Schrute'): Vault
    {
        $vault = Vault::factory()->create([
            'account_id' => $user->account->id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
        $vault->users()->save($user, [
            'contact_id' => $contact->id,
        ]);

        return $vault;
    }
}
