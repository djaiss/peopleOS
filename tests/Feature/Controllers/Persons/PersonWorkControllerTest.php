<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Person;
use App\Models\User;
use App\Models\WorkHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonWorkControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_visit_the_work_index_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);
        $workHistory = WorkHistory::factory()->create([
            'person_id' => $person->id,
            'job_title' => 'Statistical Analysis and Data Reconfiguration',
            'company_name' => 'WENUS Corp',
            'duration' => '2 years',
            'estimated_salary' => '$50,000',
            'active' => true,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/work')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
        $this->assertArrayHasKey('persons', $response);
        $this->assertArrayHasKey('workHistories', $response);

        $workHistories = $response['workHistories'];
        $this->assertCount(1, $workHistories);
        $this->assertEquals([
            'id' => $workHistory->id,
            'title' => 'Statistical Analysis and Data Reconfiguration',
            'company' => 'WENUS Corp',
            'duration' => '2 years',
            'salary' => '$50,000',
            'is_current' => true,
        ], $workHistories->first());
    }

    #[Test]
    public function a_user_can_see_a_blank_state_when_there_are_no_work_histories(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/work')
            ->assertOk();

        $response->assertSee('No work history yet');
    }

    #[Test]
    public function a_user_can_visit_the_new_work_page(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->get('/persons/'.$person->slug.'/work/new')
            ->assertOk();

        $this->assertArrayHasKey('person', $response);
    }

    #[Test]
    public function a_user_can_create_a_work_history(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
            'first_name' => 'Rachel',
            'last_name' => 'Green',
        ]);

        $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/work', [
                'title' => 'Fashion Buyer',
                'company' => 'Ralph Lauren',
                'duration' => '3 years',
                'salary' => '$75,000',
                'is_current' => 1,
            ])
            ->assertRedirectToRoute('persons.work.index', $person->slug);

        $this->assertDatabaseHas('work_information', [
            'person_id' => $person->id,
        ]);

        $workHistory = WorkHistory::where('person_id', $person->id)->first();
        $this->assertEquals('Fashion Buyer', $workHistory->job_title);
        $this->assertEquals('Ralph Lauren', $workHistory->company_name);
        $this->assertEquals('3 years', $workHistory->duration);
        $this->assertEquals('$75,000', $workHistory->estimated_salary);
        $this->assertTrue($workHistory->active);
    }

    #[Test]
    public function it_validates_required_fields_when_creating_work_history(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/work', [
                'title' => '',
                'company' => '',
                'duration' => '',
                'salary' => '',
            ]);

        $response->assertInvalid(['title' => 'required']);
    }

    #[Test]
    public function it_validates_field_lengths(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/work', [
                'title' => 'a',
                'company' => 'a',
            ]);

        $response->assertInvalid([
            'title' => 'The title field must be at least 3 characters.',
            'company' => 'The company field must be at least 3 characters.',
        ]);

        $response = $this->actingAs($user)
            ->post('/persons/'.$person->slug.'/work', [
                'title' => str_repeat('a', 256),
                'company' => str_repeat('a', 256),
            ]);

        $response->assertInvalid([
            'title' => 'The title field must not be greater than 255 characters.',
            'company' => 'The company field must not be greater than 255 characters.',
        ]);
    }
}
