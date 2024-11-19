<?php

namespace Tests\Unit\ViewModels\Vaults\Contacts;

use App\Http\ViewModels\Vaults\Contacts\ContactChildrenViewModel;
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

class ContactChildrenViewModelTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_gets_all_the_children(): void
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
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
        ]);

        $collection = ContactChildrenViewModel::index($contact);

        $this->assertEquals(1, $collection->count());
    }

    #[Test]
    public function it_gets_a_single_child(): void
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
        $child = Child::factory()->create([
            'contact_id' => $contact->id,
            'name' => 'John Doe',
            'gender' => 'Male',
            'age' => 10,
            'grade_level' => '10th',
            'school' => 'High School',
        ]);

        $array = ContactChildrenViewModel::child($child);

        $this->assertEquals(6, count($array));

        $this->assertEquals(
            [
                'id' => $child->id,
                'name' => 'John Doe',
                'gender' => 'Male',
                'age' => '10',
                'grade_level' => '10th',
                'school' => 'High School',
            ],
            $array
        );
    }
}
