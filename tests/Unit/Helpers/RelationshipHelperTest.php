<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\RelationshipHelper;
use App\Models\Account;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RelationshipHelperTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_searches_for_people_by_name(): void
    {
        $account = Account::factory()->create();

        $chandler = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $ross = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $monica = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $rachel = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
            'maiden_name' => 'Green',
        ]);

        $phoebe = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'nickname' => 'Pheebs',
        ]);

        // Create person in a different account (should not be returned)
        Person::factory()->create([
            'account_id' => Account::factory()->create()->id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        // Test search by first name
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Ros',
            personId: $chandler->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($ross->id, $result->first()['id']);

        // Test search by last name
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Gell',
            personId: $chandler->id,
        );

        $this->assertCount(2, $result);
        $this->assertTrue(
            $result->contains(fn($person) => $person['id'] === $ross->id),
        );
        $this->assertTrue(
            $result->contains(fn($person) => $person['id'] === $monica->id),
        );

        // Test search by maiden name
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Green',
            personId: $chandler->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($rachel->id, $result->first()['id']);

        // Test search by nickname
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Pheebs',
            personId: $chandler->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($phoebe->id, $result->first()['id']);

        // Test empty search
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: '',
            personId: $chandler->id,
        );

        $this->assertCount(0, $result);

        // Test no match
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Chandler',
            personId: $chandler->id,
        );

        $this->assertCount(0, $result);

        // Test results are limited to 5
        foreach (range(1, 6) as $i) {
            Person::factory()->create([
                'account_id' => $account->id,
                'first_name' => "Test{$i}",
                'last_name' => 'Person',
            ]);
        }

        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Test',
            personId: $chandler->id,
        );

        $this->assertCount(5, $result);
    }

    #[Test]
    public function it_cant_search_the_own_person_name(): void
    {
        $account = Account::factory()->create();

        $chandler = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Chandler',
            personId: $chandler->id,
        );

        $this->assertCount(0, $result);
    }

    #[Test]
    public function it_is_case_insensitive_when_searching(): void
    {
        $account = Account::factory()->create();

        $joey = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $chandler = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        // Search with mixed case
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'cHaNdLeR',
            personId: $joey->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($chandler->id, $result->first()['id']);

        // Search with uppercase
        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'BING',
            personId: $joey->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($chandler->id, $result->first()['id']);
    }

    #[Test]
    public function it_trims_search_input(): void
    {
        $account = Account::factory()->create();

        $chandler = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $joey = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
        ]);

        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: '  Joey  ',
            personId: $chandler->id,
        );

        $this->assertCount(1, $result);
        $this->assertEquals($joey->id, $result->first()['id']);
    }

    #[Test]
    public function it_returns_properly_formatted_results(): void
    {
        $account = Account::factory()->create();

        $chandler = Person::factory()->create([
            'account_id' => $account->id,
        ]);

        $rachel = Person::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
            'maiden_name' => 'Green',
            'nickname' => 'Rach',
            'slug' => 'rachel-green',
        ]);

        $result = RelationshipHelper::searchPerson(
            accountId: $account->id,
            name: 'Rachel',
            personId: $chandler->id,
        );

        $this->assertCount(1, $result);
        $resultPerson = $result->first();

        $this->assertEquals(
            [
                'id' => $rachel->id,
                'name' => 'Rachel Green',
                'maiden_name' => 'Green',
                'nickname' => 'Rach',
                'slug' => $rachel->slug,
                'avatar' => [
                    '40' => $rachel->getAvatar(40),
                    '80' => $rachel->getAvatar(80),
                ],
            ],
            $resultPerson,
        );
    }
}
