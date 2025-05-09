<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\LifeEvent;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonRelationshipControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/' . $person->slug . '/family')
            ->assertOk();

        $this->assertArrayHasKey('persons', $response);
        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('currentRelationships', $response);
        $this->assertArrayHasKey('pastRelationships', $response);
    }
}
