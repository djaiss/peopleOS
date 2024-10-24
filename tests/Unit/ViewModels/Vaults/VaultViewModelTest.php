<?php

namespace Tests\Unit\ViewModels\Vaults;

use App\Http\ViewModels\Vaults\VaultViewModel;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VaultViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create();
        $user->vaults()->sync([$vault->id => [
            'contact_id' => $contact->id,
        ]]);

        $collection = VaultViewModel::index($user);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            $vault->id,
            $collection->toArray()[0]['id']
        );
        $this->assertEquals(
            $vault->name,
            $collection->toArray()[0]['name']
        );
        $this->assertEquals(
            $vault->description,
            $collection->toArray()[0]['description']
        );
    }
}
