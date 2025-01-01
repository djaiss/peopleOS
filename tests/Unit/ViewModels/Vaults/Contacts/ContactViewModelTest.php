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
                'routes' => [
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
            'middle_name' => 'michael',
            'nickname' => 'mike',
            'maiden_name' => 'maiden',
            'patronymic_name' => 'doeaetio',
            'tribal_name' => 'doeska',
            'generation_name' => 'doekasm',
            'romanized_name' => 'doekznaew',
            'nationality' => 'american',
            'prefix' => 'mr',
            'suffix' => 'jr',
            'background_information' => 'background information',
            'job_title' => 'Paper salesman',
            'can_be_deleted' => true,
        ]);
        $company = Company::factory()->create([
            'vault_id' => $vault->id,
            'name' => 'Dunder Mifflin',
        ]);
        $contact->company_id = $company->id;
        $contact->save();

        $array = ContactViewModel::show($contact);

        $this->assertEquals(21, count($array));

        $this->assertEquals(
            $contact->id,
            $array['id']
        );
        $this->assertEquals(
            $contact->name,
            $array['name']
        );
        $this->assertEquals(
            'john',
            $array['first_name']
        );
        $this->assertEquals(
            'doe',
            $array['last_name']
        );
        $this->assertEquals(
            'michael',
            $array['middle_name']
        );
        $this->assertEquals(
            'mike',
            $array['nickname']
        );
        $this->assertEquals(
            'maiden',
            $array['maiden_name']
        );
        $this->assertEquals(
            'doeaetio',
            $array['patronymic_name']
        );
        $this->assertEquals(
            'doeska',
            $array['tribal_name']
        );
        $this->assertEquals(
            'doekasm',
            $array['generation_name']
        );
        $this->assertEquals(
            'doekznaew',
            $array['romanized_name']
        );
        $this->assertEquals(
            'american',
            $array['nationality']
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
            true,
            $array['can_be_deleted']
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
