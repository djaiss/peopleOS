<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use App\Services\GetLifeEventsListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetLifeEventsListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_life_events_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        LifeEvent::factory()->create([
            'person_id' => $person->id,
            'description' => 'Asked Monica to marry him',
            'happened_at' => '1994-03-02 00:00:00',
        ]);

        $array = (new GetLifeEventsListing(
            user: $user,
            person: $person,
        ))->execute();

        $this->assertArrayHasKeys($array, [
            'person',
            'persons',
            'life_events',
        ]);

        $this->assertEquals(1, $array['life_events']->count());
    }
}
