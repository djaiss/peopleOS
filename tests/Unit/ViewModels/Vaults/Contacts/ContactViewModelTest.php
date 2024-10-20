<?php

namespace Tests\Unit\ViewModels\Vaults\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactViewModel;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use App\Models\Vault;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
        ]);

        $collection = ContactViewModel::index($vault);

        $this->assertEquals(1, $collection->count());

        $this->assertEquals(
            [
                'id' => $contact->id,
                'name' => $contact->name,
                'url' => [
                    'show' => env('APP_URL') . '/vaults/' . $vault->id . '/contacts/' . $contact->slug,
                ],
            ],
            $collection->toArray()[0]
        );
    }

    #[Test]
    public function it_gets_the_data_needed_for_the_show_page(): void
    {
        $user = User::factory()->create();
        $vault = Vault::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $contact = Contact::factory()->create([
            'vault_id' => $vault->id,
            'first_name' => 'john',
            'last_name' => 'doe',
            'background_information' => 'background information',
            'job_title' => 'Paper salesman',
        ]);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Dunder Mifflin',
        ]);
        $contact->company_id = $company->id;
        $contact->save();

        $array = ContactViewModel::show($contact);

        $this->assertEquals(8, count($array));

        $this->assertEquals(
            $contact->id,
            $array['id']
        );
        $this->assertEquals(
            $contact->name,
            $array['name']
        );
        $this->assertEquals(
            $contact->avatar,
            $array['avatar']
        );
        $this->assertEquals(
            $contact->id . '-john',
            $array['slug']
        );
        $this->assertEquals(
            'background information',
            $array['background_information']
        );
        $this->assertEquals(
            'Paper salesman',
            $array['job_title']
        );
        $this->assertEquals(
            'Dunder Mifflin',
            $array['company']['name']
        );
        $this->assertEquals(
            '',
            $array['company']['url']
        );
        $this->assertEquals(
            [
                0 => [
                    'id' => $company->id,
                    'name' => 'Dunder Mifflin',
                ],
            ],
            $array['existing_companies']->toArray()
        );
    }
}
