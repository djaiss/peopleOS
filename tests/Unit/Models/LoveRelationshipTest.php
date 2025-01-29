<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\LoveRelationship;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoveRelationshipTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $loveRelationship = LoveRelationship::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($loveRelationship->person()->exists());
    }

    #[Test]
    public function it_belongs_to_a_related_person(): void
    {
        $person = Person::factory()->create();
        $relatedPerson = Person::factory()->create([
            'account_id' => $person->account_id,
        ]);
        $loveRelationship = LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $relatedPerson->id,
        ]);

        $this->assertTrue($loveRelationship->relatedPerson()->exists());
    }
}
