<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MaritalStatusType;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Services\UpdateLoveRelationshipStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateLoveRelationshipStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_status_to_single_when_no_current_relationship_exists(): void
    {
        $person = Person::factory()->create([
            'marital_status' => null,
        ]);

        (new UpdateLoveRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            MaritalStatusType::SINGLE->value,
            $person->fresh()->marital_status,
        );
    }

    #[Test]
    public function it_updates_status_to_couple_when_current_relationship_exists(): void
    {
        $person = Person::factory()->create([
            'marital_status' => null,
        ]);

        $partner = Person::factory()->create([
            'marital_status' => null,
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $partner->id,
            'is_current' => true,
        ]);

        (new UpdateLoveRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            MaritalStatusType::COUPLE->value,
            $person->fresh()->marital_status,
        );
    }

    #[Test]
    public function it_updates_status_for_person_listed_as_related_person(): void
    {
        $person = Person::factory()->create([
            'marital_status' => null,
        ]);

        $partner = Person::factory()->create([
            'marital_status' => null,
        ]);

        LoveRelationship::factory()->create([
            'person_id' => $partner->id,
            'related_person_id' => $person->id,
            'is_current' => true,
        ]);

        (new UpdateLoveRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            MaritalStatusType::COUPLE->value,
            $person->fresh()->marital_status,
        );
    }
}
