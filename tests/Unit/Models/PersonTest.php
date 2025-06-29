<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enums\AgeType;
use App\Enums\KidsStatusType;
use App\Models\Account;
use App\Models\Address;
use App\Models\Child;
use App\Models\EmailSent;
use App\Models\Encounter;
use App\Models\Gender;
use App\Models\Gift;
use App\Models\LifeEvent;
use App\Models\LoveRelationship;
use App\Models\Note;
use App\Models\Person;
use App\Models\Pet;
use App\Models\SpecialDate;
use App\Models\Task;
use App\Models\WorkHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $account = Account::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $this->assertTrue($person->account()->exists());
    }

    #[Test]
    public function it_belongs_to_one_gender(): void
    {
        $gender = Gender::factory()->create();
        $person = Person::factory()->create([
            'gender_id' => $gender->id,
        ]);

        $this->assertTrue($person->gender()->exists());
    }

    #[Test]
    public function it_has_many_notes(): void
    {
        $person = Person::factory()->create();
        Note::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->notes()->exists());
    }

    #[Test]
    public function it_has_many_work_histories(): void
    {
        $person = Person::factory()->create();
        WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->workHistories()->exists());
    }

    #[Test]
    public function it_has_many_gifts(): void
    {
        $person = Person::factory()->create();
        Gift::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->gifts()->exists());
    }

    #[Test]
    public function it_has_many_tasks(): void
    {
        $person = Person::factory()->create();
        Task::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->tasks()->exists());
    }

    #[Test]
    public function it_gets_the_name(): void
    {
        $person = Person::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $this->assertEquals(
            'Ross Geller',
            $person->name,
        );
    }

    #[Test]
    public function it_gets_the_current_time(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));

        $person = Person::factory()->create([
            'timezone' => 'America/New_York',
        ]);

        $this->assertEquals(
            '6:00 am',
            $person->currentTime,
        );
    }

    #[Test]
    public function it_has_many_love_relationships(): void
    {
        $ross = Person::factory()->create();

        // Test relationship as person_id
        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
        ]);
        $this->assertTrue($ross->loveRelationships()->exists());
    }

    #[Test]
    public function it_has_many_special_dates(): void
    {
        $person = Person::factory()->create();
        SpecialDate::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->specialDates()->exists());
    }

    #[Test]
    public function it_has_many_encounters(): void
    {
        $person = Person::factory()->create();
        Encounter::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->encounters()->exists());
    }

    #[Test]
    public function it_has_many_life_events(): void
    {
        $person = Person::factory()->create();
        LifeEvent::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->lifeEvents()->exists());
    }

    #[Test]
    public function it_has_many_emails_sent(): void
    {
        $person = Person::factory()->create();
        EmailSent::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->emailsSent()->exists());
    }

    #[Test]
    public function it_has_many_children_as_first_parent(): void
    {
        $person = Person::factory()->create();
        Child::factory()->create([
            'parent_id' => $person->id,
        ]);

        $this->assertTrue($person->childrenAsParent()->exists());
    }

    #[Test]
    public function it_has_many_children_as_second_parent(): void
    {
        $person = Person::factory()->create();
        Child::factory()->create([
            'second_parent_id' => $person->id,
        ]);

        $this->assertTrue($person->childrenAsSecondParent()->exists());
    }

    #[Test]
    public function it_has_many_children(): void
    {
        $ross = Person::factory()->create();
        $rachel = Person::factory()->create();
        Child::factory()->create([
            'parent_id' => $ross->id,
            'second_parent_id' => $rachel->id,
        ]);

        $children = $ross->children();

        $this->assertCount(1, $children);
        $this->assertNotEmpty($children);
        $this->assertEquals($ross->id, $children->first()->parent_id);
        $this->assertEquals($rachel->id, $children->first()->second_parent_id);
    }

    #[Test]
    public function it_has_many_pets(): void
    {
        $person = Person::factory()->create();
        Pet::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($person->pets()->exists());
    }

    #[Test]
    public function it_has_one_special_date_associated_with_the_how_i_met_occasion(): void
    {
        $person = Person::factory()->create();
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $person->account_id,
            'person_id' => $person->id,
            'name' => 'How I Met',
        ]);
        $person->how_we_met_special_date_id = $specialDate->id;
        $person->save();

        $this->assertTrue($person->howWeMetSpecialDate()->exists());
    }

    #[Test]
    public function it_has_one_special_date_associated_with_the_age_of_the_person(): void
    {
        $person = Person::factory()->create();
        $specialDate = SpecialDate::factory()->create([
            'account_id' => $person->account_id,
            'person_id' => $person->id,
            'name' => 'Age',
        ]);
        $person->age_special_date_id = $specialDate->id;
        $person->save();

        $this->assertTrue($person->ageSpecialDate()->exists());
    }

    #[Test]
    public function it_checks_if_person_has_active_love_relationship(): void
    {
        $ross = Person::factory()->create();
        $rachel = Person::factory()->create([
            'account_id' => $ross->account_id,
        ]);

        // Create an active relationship
        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'is_current' => true,
        ]);

        $this->assertTrue($ross->hasActiveLoveRelationship());

        // Test with no active relationships
        $monica = Person::factory()->create();
        $this->assertFalse($monica->hasActiveLoveRelationship());

        // Test with only inactive relationships
        LoveRelationship::factory()->create([
            'person_id' => $monica->id,
            'related_person_id' => $ross->id,
            'is_current' => false,
        ]);
        $this->assertFalse($monica->hasActiveLoveRelationship());
    }

    #[Test]
    public function it_gets_the_active_partners_as_person_collection(): void
    {
        $ross = Person::factory()->create();
        $rachel = Person::factory()->create([
            'account_id' => $ross->account_id,
        ]);
        $monica = Person::factory()->create([
            'account_id' => $ross->account_id,
        ]);
        $chandler = Person::factory()->create([
            'account_id' => $ross->account_id,
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'is_current' => true,
        ]);
        LoveRelationship::factory()->create([
            'person_id' => $chandler->id,
            'related_person_id' => $ross->id,
            'is_current' => true,
        ]);
        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $monica->id,
            'is_current' => false,
        ]);

        $collection = $ross->getActivePartnersAsPersonCollection();
        $this->assertCount(2, $collection);
        $this->assertEquals($rachel->id, $collection->first()->id);
        $this->assertEquals($chandler->id, $collection->last()->id);
    }

    #[Test]
    public function it_gets_the_job_title(): void
    {
        $ross = Person::factory()->create();
        WorkHistory::factory()->create([
            'person_id' => $ross->id,
            'job_title' => 'Developer',
            'active' => true,
        ]);

        $this->assertEquals('Developer', $ross->job());
    }

    #[Test]
    public function it_returns_null_if_no_active_job(): void
    {
        $ross = Person::factory()->create();
        $this->assertNull($ross->job());
    }

    #[Test]
    public function it_gets_the_estimated_age(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));
        $ross = Person::factory()->create([
            'estimated_age' => 30,
            'age_estimated_at' => Carbon::parse('2020-01-01'),
        ]);

        $this->assertEquals('Probably 35 years old', $ross->getEstimatedAge());
    }

    #[Test]
    public function it_returns_the_exact_age(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00'));
        $ross = Person::factory()->create([
            'age_type' => AgeType::EXACT->value,
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $ross->id,
            'year' => 1990,
            'month' => 10,
            'day' => 29,
        ]);
        $ross->age_special_date_id = $specialDate->id;
        $ross->save();

        $this->assertEquals('34 years old', $ross->age);
    }

    #[Test]
    public function it_returns_the_age_bracket(): void
    {
        $ross = Person::factory()->create([
            'age_type' => AgeType::BRACKET->value,
            'age_bracket' => '20-29',
        ]);

        $this->assertEquals('20-29', $ross->age);
    }

    #[Test]
    public function it_checks_if_person_has_physical_details(): void
    {
        $ross = Person::factory()->create();
        $this->assertFalse($ross->hasPhysicalDetails());

        $ross->height = 180;
        $ross->save();
        $this->assertTrue($ross->hasPhysicalDetails());
    }

    #[Test]
    public function it_gets_the_marital_status(): void
    {
        $ross = Person::factory()->create([
            'marital_status' => 'Single',
        ]);

        // Test with no active relationships
        $this->assertEquals(
            'Single',
            $ross->getMaritalStatus(),
        );

        // Test with one active relationship
        $rachel = Person::factory()->create([
            'account_id' => $ross->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
            'is_current' => true,
        ]);

        $this->assertEquals(
            'In a relationship with Rachel Green',
            $ross->getMaritalStatus(),
        );

        // Test with multiple active relationships
        $emily = Person::factory()->create([
            'account_id' => $ross->account_id,
            'first_name' => 'Emily',
            'last_name' => 'Waltham',
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $emily->id,
            'is_current' => true,
        ]);

        $this->assertEquals(
            'In a relationship with Rachel Green and Emily Waltham',
            $ross->getMaritalStatus(),
        );

        // Test when person is the related person in a relationship
        $monica = Person::factory()->create([
            'account_id' => $ross->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $monica->id,
            'related_person_id' => $ross->id,
            'is_current' => true,
        ]);

        $this->assertEquals(
            'In a relationship with Rachel Green, Emily Waltham and Monica Geller',
            $ross->getMaritalStatus(),
        );
    }

    #[Test]
    public function it_gets_children_names_with_named_and_unnamed_children(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'Regis',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'John',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);

        $this->assertEquals('Regis and John and 2 other kids', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_one_named_and_one_unnamed_child(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'Regis',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);

        $this->assertEquals('Regis and 1 other kid', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_all_unnamed_children(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);

        $this->assertEquals('3 kids', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_one_named_and_multiple_unnamed_children(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'John',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);

        $this->assertEquals('John and 2 other kids', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_only_named_children(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'John',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'Jane',
        ]);

        $this->assertEquals('John and Jane', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_single_unnamed_child(): void
    {
        $ross = Person::factory()->create();

        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => null,
        ]);

        $this->assertEquals('1 kid', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_children_names_with_no_children(): void
    {
        $ross = Person::factory()->create();

        $this->assertEquals('0 kids', $ross->getChildrenNames());
    }

    #[Test]
    public function it_gets_the_children_status(): void
    {
        $ross = Person::factory()->create();

        // Test HAS_KIDS status
        $ross->kids_status = KidsStatusType::HAS_KIDS->value;
        $ross->save();
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'Emma',
        ]);
        Child::factory()->create([
            'parent_id' => $ross->id,
            'first_name' => 'Ben',
        ]);
        $this->assertEquals('Emma and Ben', $ross->getChildrenStatus());

        // Test MAYBE_KIDS status
        $ross->kids_status = KidsStatusType::MAYBE_KIDS->value;
        $ross->save();
        $this->assertEquals('May have kids', $ross->getChildrenStatus());

        // Test UNKNOWN status
        $ross->kids_status = KidsStatusType::UNKNOWN->value;
        $ross->save();
        $this->assertEquals('Unknown', $ross->getChildrenStatus());

        // Test NO_KIDS status
        $ross->kids_status = KidsStatusType::NO_KIDS->value;
        $ross->save();
        $this->assertEquals('No kids', $ross->getChildrenStatus());
    }

    #[Test]
    public function it_gets_pets_with_named_and_unnamed_pets(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Fluffy',
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Rex',
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);

        $this->assertEquals('Fluffy and Rex and 2 other pets', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_one_named_and_one_unnamed_pet(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Fluffy',
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);

        $this->assertEquals('Fluffy and 1 other pet', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_all_unnamed_pets(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);

        $this->assertEquals('3 pets', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_one_named_and_multiple_unnamed_pets(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Rex',
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);

        $this->assertEquals('Rex and 2 other pets', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_only_named_pets(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Fluffy',
        ]);
        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Rex',
        ]);

        $this->assertEquals('Fluffy and Rex', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_single_unnamed_pet(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => null,
        ]);

        $this->assertEquals('1 pet', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_no_pets(): void
    {
        $ross = Person::factory()->create();

        $this->assertEquals('No pets', $ross->getPets());
    }

    #[Test]
    public function it_gets_pets_with_single_named_pet(): void
    {
        $ross = Person::factory()->create();

        Pet::factory()->create([
            'person_id' => $ross->id,
            'name' => 'Fluffy',
        ]);

        $this->assertEquals('Fluffy', $ross->getPets());
    }

    #[Test]
    public function it_has_many_addresses(): void
    {
        $ross = Person::factory()->create();
        Address::factory()->create([
            'person_id' => $ross->id,
        ]);

        $this->assertTrue($ross->addresses()->exists());
    }
}
