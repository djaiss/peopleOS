<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\KidsStatusType;
use App\Models\Child;
use App\Models\Person;
use App\Services\UpdateParentRelationshipStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateParentRelationshipStatusTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_updates_status_to_no_kids_when_no_children_exist(): void
    {
        $person = Person::factory()->create([
            'kids_status' => null,
        ]);

        (new UpdateParentRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            KidsStatusType::NO_KIDS->value,
            $person->fresh()->kids_status,
        );
    }

    #[Test]
    public function it_updates_status_to_has_kids_when_person_is_parent(): void
    {
        $person = Person::factory()->create([
            'kids_status' => null,
        ]);

        Child::factory()->create([
            'parent_id' => $person->id,
        ]);

        (new UpdateParentRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            KidsStatusType::HAS_KIDS->value,
            $person->fresh()->kids_status,
        );
    }

    #[Test]
    public function it_updates_status_to_has_kids_when_person_is_second_parent(): void
    {
        $person = Person::factory()->create([
            'kids_status' => null,
        ]);

        Child::factory()->create([
            'second_parent_id' => $person->id,
        ]);

        (new UpdateParentRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            KidsStatusType::HAS_KIDS->value,
            $person->fresh()->kids_status,
        );
    }

    #[Test]
    public function it_updates_status_to_has_kids_when_person_is_both_parents(): void
    {
        $person = Person::factory()->create([
            'kids_status' => null,
        ]);

        Child::factory()->create([
            'parent_id' => $person->id,
            'second_parent_id' => $person->id,
        ]);

        (new UpdateParentRelationshipStatus(
            person: $person,
        ))->execute();

        $this->assertEquals(
            KidsStatusType::HAS_KIDS->value,
            $person->fresh()->kids_status,
        );
    }
}
