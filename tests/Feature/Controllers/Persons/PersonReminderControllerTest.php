<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\SpecialDate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonReminderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_reminders_index_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);
        $specialDate = SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'name' => 'Birthday',
            'month' => 10,
            'day' => 18,
            'year' => 1967,
            'should_be_reminded' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/reminders')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
        $this->assertArrayHasKey('months', $response);
        $this->assertArrayHasKey('totalReminders', $response);

        $months = $response['months'];
        $this->assertCount(1, $months);
        $this->assertEquals([
            'number' => 10,
            'name' => 'October',
            'color' => 'cyan',
            'reminders' => collect([
                [
                    'id' => $specialDate->id,
                    'day' => 18,
                    'date' => $specialDate->date,
                    'name' => 'Birthday',
                    'age' => $specialDate->age,
                ],
            ]),
        ], $months->first());
    }

    #[Test]
    public function it_only_shows_reminders_that_should_be_reminded(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'should_be_reminded' => false,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/reminders')
            ->assertOk();

        $this->assertEquals(0, $response['totalReminders']);
        $this->assertCount(0, $response['months']);
    }

    #[Test]
    public function it_returns_correct_month_colors(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'month' => 1,
            'should_be_reminded' => true,
        ]);
        SpecialDate::factory()->create([
            'person_id' => $person->id,
            'account_id' => $user->account_id,
            'month' => 12,
            'should_be_reminded' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/reminders')
            ->assertOk();

        $months = $response['months'];
        $this->assertEquals('blue', $months[0]['color']); // January
        $this->assertEquals('red', $months[1]['color']); // December
    }
}
