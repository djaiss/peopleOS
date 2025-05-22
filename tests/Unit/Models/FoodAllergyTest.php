<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\FoodAllergy;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FoodAllergyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_a_person(): void
    {
        $person = Person::factory()->create();
        $allergy = FoodAllergy::factory()->create([
            'person_id' => $person->id,
        ]);

        $this->assertTrue($allergy->person()->exists());
    }
}
