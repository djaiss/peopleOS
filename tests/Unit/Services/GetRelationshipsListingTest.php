<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Child;
use App\Models\LoveRelationship;
use App\Models\Person;
use App\Models\Pet;
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
        $ross = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        // Create current relationship
        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);
        $currentRelationship = LoveRelationship::factory()->create([
            'person_id' => $ross->id,
            'related_person_id' => $rachel->id,
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
            'person_id' => $ross->id,
            'related_person_id' => $pastPerson->id,
            'type' => 'Dating',
            'is_current' => false,
        ]);

        // create child
        $child = Child::factory()->create([
            'first_name' => 'Ben',
            'last_name' => 'Geller',
            'parent_id' => $ross->id,
            'second_parent_id' => $rachel->id,
        ]);

        // create pet
        $pet = Pet::factory()->create([
            'account_id' => $user->account_id,
            'person_id' => $ross->id,
            'name' => 'Phoebe',
            'species' => 'cat',
            'breed' => 'Siamese',
            'gender' => 'female',
        ]);

        $array = (new GetRelationshipsListing(
            person: $ross,
        ))->execute();

        $this->assertArrayHasKey('currentRelationships', $array);
        $this->assertArrayHasKey('pastRelationships', $array);
        $this->assertArrayHasKey('children', $array);
        $this->assertArrayHasKey('pets', $array);

        $this->assertCount(1, $array['currentRelationships']);
        $this->assertCount(1, $array['pastRelationships']);
        $this->assertCount(1, $array['children']);
        $this->assertCount(1, $array['pets']);

        $currentRelationshipData = $array['currentRelationships']->first();
        $this->assertEquals([
            'id' => $currentRelationship->id,
            'person' => [
                'id' => $rachel->id,
                'name' => 'Rachel Green',
                'slug' => $rachel->slug,
                'is_listed' => $rachel->is_listed,
                'avatar' => [
                    '40' => $rachel->getAvatar(40),
                    '80' => $rachel->getAvatar(80),
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

        $childData = $array['children']->first();
        $this->assertEquals([
            'id' => $child->id,
            'name' => 'Ben Geller',
        ], $childData);

        $petData = $array['pets']->first();
        $this->assertEquals([
            'id' => $pet->id,
            'name' => 'Phoebe',
            'species' => 'cat',
            'breed' => 'Siamese',
            'gender' => 'female',
        ], $petData);
    }
}
