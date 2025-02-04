<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPersonalizationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function administration_personalization_index_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
            'position' => 1,
        ]);
        $maritalStatus = MaritalStatus::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Single',
            'position' => 1,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.index');
        $this->assertArrayHasKey('genders', $response);
        $this->assertArrayHasKey('maritalStatuses', $response);
        $genders = $response['genders'];
        $this->assertCount(1, $genders);
        $this->assertEquals([
            'id' => $gender->id,
            'name' => 'Male',
        ], $genders[0]);

        $maritalStatuses = $response['maritalStatuses'];
        $this->assertCount(1, $maritalStatuses);
        $this->assertEquals([
            'id' => $maritalStatus->id,
            'name' => 'Single',
        ], $maritalStatuses[0]);
    }
}
