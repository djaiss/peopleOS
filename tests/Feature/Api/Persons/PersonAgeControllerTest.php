<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Persons;

use App\Enums\AgeType;
use App\Models\Person;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;
use PHPUnit\Framework\Attributes\Test;

class PersonAgeControllerTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_should_update_exact_age_successfully_when_all_fields_provided(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-01 10:00:00'));

        $user = User::factory()->create();
        $ross = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PATCH', "/api/persons/{$ross->id}/age", [
                'age_type' => AgeType::EXACT->value,
                'age_year' => 1967,
                'age_month' => 10,
                'age_day' => 18,
                'add_yearly_reminder' => true,
            ]);

        $response->assertOk();
    }

    #[Test]
    public function it_should_update_estimated_age_successfully_when_age_provided(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-01 10:00:00'));

        $user = User::factory()->create();
        $chandler = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PATCH', "/api/persons/{$chandler->id}/age", [
                'age_type' => AgeType::ESTIMATED->value,
                'estimated_age' => 25,
                'add_yearly_reminder' => false,
            ]);

        $response->assertOk();
    }

    #[Test]
    public function it_should_update_age_bracket_successfully_when_bracket_provided(): void
    {
        Carbon::setTestNow(Carbon::parse('2024-04-01 10:00:00'));

        $user = User::factory()->create();
        $monica = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PATCH', "/api/persons/{$monica->id}/age", [
                'age_type' => 'bracket',
                'age_bracket' => '18-25',
                'add_yearly_reminder' => false,
            ]);

        $response->assertOk();
    }

    #[Test]
    public function it_should_fail_when_user_doesnt_belong_to_account(): void
    {
        $user = User::factory()->create();
        $rachel = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        /** @var Authenticatable $otherUser */
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)
            ->json('PATCH', "/api/persons/{$rachel->id}/age", [
                'age_type' => AgeType::EXACT->value,
                'age_year' => 1969,
                'age_month' => 5,
                'age_day' => 5,
                'add_yearly_reminder' => true,
            ]);

        $response->assertNotFound();
    }

    #[Test]
    public function it_should_fail_when_age_type_is_invalid(): void
    {
        $user = User::factory()->create();
        $phoebe = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        $response = $this->actingAs($user)
            ->json('PATCH', "/api/persons/{$phoebe->id}/age", [
                'age_type' => 'invalid',
                'age_year' => 1969,
                'add_yearly_reminder' => true,
            ]);

        $response->assertUnprocessable();
    }
}
