<?php

namespace Tests\Unit\Services;

use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use App\Services\UpdateBackgroundInformation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateBackgroundInformationTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_the_background_information(): void
    {
        $user = User::factory()->create();
        $vault = $this->createVault($user);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    #[Test]
    public function it_fails_if_vault_doesnt_belong_to_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    #[Test]
    public function it_fails_if_contact_doesnt_belong_to_vault(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $vault = Vault::factory()->create();
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $this->executeService($user, $contact);
    }

    private function executeService(User $user, Contact $contact): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        (new UpdateBackgroundInformation(
            user: $user,
            contact: $contact,
            information: 'This is awesome',
        ))->execute();

        $contact = $contact->fresh();

        $this->assertEquals(
            'This is awesome',
            $contact->background_information
        );

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'updated_at' => '2018-01-01 00:00:00',
        ]);
    }
}
