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
    public function new_gender_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/personalization/genders/new');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.partials.gender-new');
    }

    #[Test]
    public function user_can_create_a_gender(): void
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
    }

    #[Test]
    public function edit_gender_page_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Female',
        ]);

        $response = $this->actingAs($user)
            ->get('/administration/personalization/genders/'.$gender->id.'/edit');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.partials.gender-edit');
        $response->assertViewHas('gender', $gender);
    }

    #[Test]
    public function user_cannot_edit_gender_from_another_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/personalization/genders/'.$gender->id.'/edit');

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_update_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
            'name' => 'Male',
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/personalization/genders/'.$gender->id.'/edit')
            ->put('/administration/personalization/genders/'.$gender->id, [
                'name' => 'Non-binary',
            ]);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Gender updated'));

        $this->assertDatabaseHas('genders', [
            'id' => $gender->id,
        ]);

        $this->assertEquals('Non-binary', $gender->refresh()->name);
    }

    #[Test]
    public function user_cannot_update_gender_from_another_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        $response = $this->actingAs($user)
            ->put('/administration/personalization/genders/'.$gender->id, [
                'name' => 'Non-binary',
            ]);

        $response->assertStatus(404);
    }

    #[Test]
    public function user_can_delete_a_gender(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->from('/administration/personalization')
            ->delete('/administration/personalization/genders/'.$gender->id);

        $response->assertRedirect('/administration/personalization');
        $response->assertSessionHas('status', __('Gender deleted'));

        $this->assertDatabaseMissing('genders', [
            'id' => $gender->id,
        ]);
    }

    #[Test]
    public function user_cannot_delete_gender_from_another_account(): void
    {
        $user = User::factory()->create();
        $gender = Gender::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/administration/personalization/genders/'.$gender->id);

        $response->assertStatus(404);
    }
}
