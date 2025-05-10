<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\User;
use App\Services\GetRelationshipsListing;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetRelationshipsListingTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_the_data_for_the_relationships_listing_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        // Create current relationship
        $currentPerson = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $currentRelationship = LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $currentPerson->id,
            'type' => 'Married',
            'is_current' => true,
        ]);

        // Create past relationship
        $pastPerson = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);
        $pastRelationship = LoveRelationship::factory()->create([
            'person_id' => $person->id,
            'related_person_id' => $pastPerson->id,
            'type' => 'Dating',
            'is_current' => false,
        ]);

        $array = (new GetRelationshipsListing(
            person: $person,
        ))->execute();

        $this->assertArrayHasKey('currentRelationships', $array);
        $this->assertArrayHasKey('pastRelationships', $array);

        $this->assertCount(1, $array['currentRelationships']);
        $this->assertCount(1, $array['pastRelationships']);

        $currentRelationshipData = $array['currentRelationships']->first();
        $this->assertEquals([
            'id' => $currentRelationship->id,
            'person' => [
                'id' => $currentPerson->id,
                'name' => 'Rachel Green',
                'slug' => $currentPerson->slug,
                'is_listed' => $currentPerson->is_listed,
                'avatar' => [
                    '40' => $currentPerson->getAvatar(40),
                    '80' => $currentPerson->getAvatar(80),
                ],
            ],
            'type' => 'Married',
            'is_new' => false,
        ], $currentRelationshipData);

        $pastRelationshipData = $array['pastRelationships']->first();
        $this->assertEquals([
            'id' => $pastRelationship->id,
            'person' => [
                'id' => $pastPerson->id,
                'name' => 'Monica Geller',
                'slug' => $pastPerson->slug,
                'is_listed' => $pastPerson->is_listed,
                'avatar' => [
                    '40' => $pastPerson->getAvatar(40),
                    '80' => $pastPerson->getAvatar(80),
                ],
            ],
            'type' => 'Dating',
            'is_new' => false,
        ], $pastRelationshipData);
    }
}
