<?php

namespace Tests\Unit\ViewModels\Vaults\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactPartnerViewModel;
use App\Models\Contact;
use App\Models\MaritalStatus;
use App\Models\Partner;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactPartnerViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_partners(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'John',
        ]);
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        Partner::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $collection = ContactPartnerViewModel::index($contact);

        $this->assertEquals(1, $collection->count());
    }

    #[Test]
    public function it_gets_a_single_partner(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $user = User::factory()->create([
            'first_name' => 'John',
        ]);
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'label' => 'Married',
        ]);
        $partner = Partner::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'Jane Doe',
            'marital_status_id' => $maritalStatus->id,
            'occupation' => 'Developer',
            'number_of_years_together' => 5,
        ]);

        $array = ContactPartnerViewModel::partner($partner);

        $this->assertEquals(5, count($array));

        $this->assertEquals(
            [
                'id' => $partner->id,
                'name' => 'Jane Doe',
                'marital_status' => [
                    'id' => $maritalStatus->id,
                    'label' => 'Married',
                ],
                'occupation' => 'Developer',
                'number_of_years_together' => 5,
            ],
            $array
        );
    }
}
