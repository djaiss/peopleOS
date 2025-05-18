<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationGenderControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_gender(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/administration/personalization/genders/new')
            ->post('/administration/personalization/genders', [
                'name' => 'Male',
            ]);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Gender created'));

        $this->assertDatabaseHas('genders', [
            'account_id' => $user->account_id,
        ]);

        $this->assertEquals('Male', Gender::latest()->first()->name);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertSee('Male');
    }

    #[Test]
    public function it_can_edit_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization/genders/' . $gender->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.partials.gender-edit');
        $response->assertViewHas('gender', $gender);

        $response = $this->actingAs($user)
            ->from('/administration/personalization/genders/' . $gender->id . '/edit')
            ->put('/administration/personalization/genders/' . $gender->id, [
                'name' => 'Male',
            ]);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Gender updated'));

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
        ]);

        $this->assertEquals('Male', $gender->refresh()->name);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertSee('Male');
    }

    #[Test]
    public function it_can_delete_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/personalization')
            ->delete('/administration/personalization/genders/' . $gender->id);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Gender deleted'));

        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertDontSee('Male');
    }
}
