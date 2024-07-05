<?php

namespace Tests\Unit\Models;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_has_one_account()
    {
        $regis = User::factory()->create();

        $this->assertTrue($regis->account()->exists());
    }

    #[Test]
    public function it_has_many_vaults(): void
    {
        $regis = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $regis->account_id,
        ]);
        $contact = Contact::factory()->create();

        $regis->vaults()->sync([$vault->id => [
            'permission' => Vault::PERMISSION_MANAGE,
            'contact_id' => $contact->id,
        ]]);

        $this->assertTrue($regis->vaults()->exists());
    }
}
