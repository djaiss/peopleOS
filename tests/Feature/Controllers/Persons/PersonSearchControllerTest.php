<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonSearchControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_search_persons_by_name(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Monica',
            'last_name' => 'Geller',
            'is_listed' => true,
        ]);
        Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
            'is_listed' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => 'mon',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('persons', $response);
        $this->assertCount(1, $response['persons']);
        $this->assertEquals([
            'id' => $person->id,
            'name' => 'Monica Geller',
            'maiden_name' => '',
            'nickname' => '',
            'slug' => $person->slug,
            'avatar' => [
                '40' => $person->getAvatar(40),
                '80' => $person->getAvatar(80),
            ],
        ], $response['persons']->first());
    }

    #[Test]
    public function it_can_search_persons_by_nickname(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Phoebe',
            'last_name' => 'Buffay',
            'nickname' => 'Pheebs',
            'is_listed' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => 'phee',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('persons', $response);
        $this->assertCount(1, $response['persons']);
        $this->assertEquals([
            'id' => $person->id,
            'name' => 'Phoebe Buffay',
            'maiden_name' => '',
            'nickname' => 'Pheebs',
            'slug' => $person->slug,
            'avatar' => [
                '40' => $person->getAvatar(40),
                '80' => $person->getAvatar(80),
            ],
        ], $response['persons']->first());
    }

    #[Test]
    public function it_can_search_persons_by_maiden_name(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
            'maiden_name' => 'Greene',
            'is_listed' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => 'greene',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('persons', $response);
        $this->assertCount(1, $response['persons']);
        $this->assertEquals([
            'id' => $person->id,
            'name' => 'Rachel Green',
            'maiden_name' => 'Greene',
            'nickname' => '',
            'slug' => $person->slug,
            'avatar' => [
                '40' => $person->getAvatar(40),
                '80' => $person->getAvatar(80),
            ],
        ], $response['persons']->first());
    }

    #[Test]
    public function it_only_returns_persons_from_user_account(): void
    {
        $user = User::factory()->create();
        Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'is_listed' => true,
        ]);

        // Create person in different account
        Person::factory()->create([
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
            'is_listed' => true,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => 'chandler',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('persons', $response);
        $this->assertCount(1, $response['persons']);
    }

    #[Test]
    public function it_only_returns_listed_persons(): void
    {
        $user = User::factory()->create();
        Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Joey',
            'last_name' => 'Tribbiani',
            'is_listed' => false,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => 'joey',
            ]);

        $response->assertOk();
        $this->assertArrayHasKey('persons', $response);
        $this->assertCount(0, $response['persons']);
    }

    #[Test]
    public function it_validates_search_term(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => '',
            ]);

        $response->assertInvalid(['term' => 'required']);

        $response = $this->actingAs($user)
            ->post('/persons/search', [
                'term' => str_repeat('a', 256),
            ]);

        $response->assertInvalid(['term' => 'The term field must not be greater than 255 characters.']);
    }
}
