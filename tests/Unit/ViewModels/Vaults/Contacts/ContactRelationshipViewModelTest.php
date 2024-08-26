<?php

namespace Tests\Unit\ViewModels\Vaults\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactRelationshipViewModel;
use App\Http\ViewModels\Vaults\Contacts\ContactNotesViewModel;
use App\Models\Child;
use App\Models\Contact;
use App\Models\Note;
use App\Models\User;
use App\Models\Vault;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactRelationshipViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_children(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $contact = Contact::factory()->create();
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'Kevin the Third',
            'gender' => Contact::GENDER_FEMALE,
        ]);

        $array = ContactRelationshipViewModel::index($contact);

        $this->assertEquals(1, count($array));

        $this->assertEquals(
            [
                'id' => $child->id,
                'name' => 'Kevin the Third',
                'gender' => 'female',
            ],
            $array['children'][0]
        );
    }

    #[Test]
    public function it_gets_a_single_child(): void
    {
        Carbon::setTestNow(Carbon::create(2018, 1, 1));
        $contact = Contact::factory()->create();
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'Kevin the Third',
            'gender' => Contact::GENDER_FEMALE,
        ]);

        $array = ContactRelationshipViewModel::child($child);

        $this->assertEquals(3, count($array));

        $this->assertEquals(
            [
                'id' => $child->id,
                'name' => 'Kevin the Third',
                'gender' => 'female',
            ],
            $array
        );
    }
}
