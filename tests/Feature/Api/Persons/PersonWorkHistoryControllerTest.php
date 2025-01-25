<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonWorkHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_create_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/persons/'.$person->id.'/work-history', [
            'company_name' => 'New York Museum of Prehistoric History',
            'job_title' => 'Paleontologist',
            'estimated_salary' => '$75,000',
            'duration' => '1 year',
            'active' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('work_information', [
            'person_id' => $person->id,
        ]);

        $workHistory = WorkHistory::where('person_id', $person->id)->first();

        $this->assertEquals('New York Museum of Prehistoric History', $workHistory->company_name);
        $this->assertEquals('Paleontologist', $workHistory->job_title);
        $this->assertEquals('$75,000', $workHistory->estimated_salary);
        $this->assertEquals('1 year', $workHistory->duration);
        $this->assertTrue($workHistory->active);
    }

    #[Test]
    public function user_can_update_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'company_name' => 'Original Company',
            'job_title' => 'Original Title',
            'estimated_salary' => '$50,000',
            'active' => false,
            'duration' => '1 year',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id, [
            'company_name' => 'New York University',
            'job_title' => 'Professor',
            'estimated_salary' => '$85,000',
            'active' => true,
            'duration' => '2 years',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('work_information', [
            'id' => $workHistory->id,
        ]);

        $this->assertEquals(
            'New York University',
            $workHistory->refresh()->company_name
        );
        $this->assertEquals('2 years', $workHistory->refresh()->duration);
        $this->assertEquals('New York University', $response->json('data.company_name'));
        $this->assertEquals('Professor', $response->json('data.job_title'));
        $this->assertEquals('$85,000', $response->json('data.estimated_salary'));
        $this->assertTrue($response->json('data.active'));
    }

    #[Test]
    public function user_cannot_update_work_history_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('PUT', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id, [
            'company_name' => 'Updated Company',
            'job_title' => 'Updated Title',
            'estimated_salary' => '$100,000',
            'active' => true,
        ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('work_information', [
            'id' => $workHistory->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_work_history_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('DELETE', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_a_work_history_entry(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'company_name' => 'Central Perk',
            'job_title' => 'Barista',
            'estimated_salary' => '$30,000',
            'duration' => '1 year',
            'active' => true,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $workHistory->id,
            'company_name' => 'Central Perk',
            'job_title' => 'Barista',
            'estimated_salary' => '$30,000',
            'active' => true,
            'duration' => '1 year',
        ]);
    }

    #[Test]
    public function user_cannot_get_work_history_from_another_account(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/work-history/'.$workHistory->id);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_get_list_of_work_history_entries(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'company_name' => 'Central Perk',
            'job_title' => 'Barista',
            'estimated_salary' => '$30,000',
            'active' => true,
            'duration' => '1 year',
        ]);

        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/persons/'.$person->id.'/work-history');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $workHistory->id,
            'company_name' => 'Central Perk',
            'job_title' => 'Barista',
            'estimated_salary' => '$30,000',
            'active' => true,
            'duration' => '1 year',
        ]);
    }
}
