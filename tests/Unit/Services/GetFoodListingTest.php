<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Person;
use App\Services\GetFoodListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetFoodListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_food_listing_page(): void
    {
        $person = Person::factory()->create();

        $array = (new GetFoodListing(
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'food_allergies',
        ]);
    }
}
