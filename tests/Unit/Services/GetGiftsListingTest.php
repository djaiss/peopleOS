<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\GiftStatus;
use App\Models\Gift;
use App\Models\Person;
use App\Models\User;
use App\Services\GetGiftsListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetGiftsListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_gifts_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        Gift::factory()->create([
            'person_id' => $person->id,
            'status' => GiftStatus::IDEA->value,
        ]);
        Gift::factory()->create([
            'person_id' => $person->id,
            'status' => GiftStatus::RECEIVED->value,
        ]);
        Gift::factory()->create([
            'person_id' => $person->id,
            'status' => GiftStatus::GIVEN->value,
        ]);

        $array = (new GetGiftsListing(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'gifts',
            'idea_gifts_count',
            'received_gifts_count',
            'offered_gifts_count',
        ]);

        $this->assertEquals(1, $array['idea_gifts_count']);
        $this->assertEquals(1, $array['received_gifts_count']);
        $this->assertEquals(1, $array['offered_gifts_count']);
    }
}
