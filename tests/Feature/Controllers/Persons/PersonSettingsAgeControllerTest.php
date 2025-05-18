<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Enums\AgeType;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonSettingsAgeControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_update_exact_age_when_birthdate_provided(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-25 10:00:00'));

        $user = User::factory()->create();
        $joey = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->actingAs($user);

        $response = $this->json('PUT', "/persons/{$joey->slug}/settings/age", [
            'age' => 'exact',
            'birthdate' => '1970-07-25',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status', trans('Changes saved'));
    }

    #[Test]
    public function it_should_update_estimated_age_when_age_provided(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-25 10:00:00'));

        $user = User::factory()->create();
        $chandler = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $this->actingAs($user);

        $response = $this->json('PUT', "/persons/{$chandler->slug}/settings/age", [
            'age' => 'estimated',
            'estimated_age' => 35,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status', trans('Changes saved'));

        $this->assertEquals(
            AgeType::ESTIMATED->value,
            $chandler->fresh()->age_type,
        );
        $this->assertEquals(35, $chandler->fresh()->estimated_age);
    }

    #[Test]
    public function it_should_not_update_anything_when_age_is_unknown(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-25 10:00:00'));

        $user = User::factory()->create();
        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
            'age_type' => AgeType::ESTIMATED->value,
            'estimated_age' => 30,
        ]);
        $this->actingAs($user);

        $response = $this->json('PUT', "/persons/{$rachel->slug}/settings/age", [
            'age' => 'unknown',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('status', trans('Changes saved'));
    }
}
