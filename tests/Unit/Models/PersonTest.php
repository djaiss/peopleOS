<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Gender;
use App\Models\LoveRelationship;
use App\Models\MaritalStatus;
use App\Models\Note;
use App\Models\Person;
use App\Models\WorkHistory;
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
    public function it_belongs_to_one_marital_status(): void
    {
        $maritalStatus = MaritalStatus::factory()->create();
        $person = Person::factory()->create([
            'marital_status_id' => $maritalStatus->id,
        ]);

        $this->assertTrue($person->maritalStatus()->exists());
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
    public function it_gets_the_name(): void
    {
        $person = Person::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $this->assertEquals(
            'Ross Geller',
            $person->name
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
}
