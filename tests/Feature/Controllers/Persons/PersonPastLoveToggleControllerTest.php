<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Persons;

use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\TogglePastLoveRelationshipsVisibility;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PersonPastLoveToggleControllerTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;
    private User $user;
    private Person $person;

    #[Test]
    public function it_toggles_past_love_relationships_visibility(): void
    {
        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
            'show_past_love_relationships' => true,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('person.love.toggle', $this->person->slug));

        $response->assertRedirect(route('person.family.index', $this->person->slug));
        $this->assertFalse($this->person->fresh()->show_past_love_relationships);
    }

    #[Test]
    public function it_fails_if_user_doesnt_belong_to_the_same_account(): void
    {
        $this->account = Account::factory()->create();
        $this->user = User::factory()->create();
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('person.love.toggle', $this->person->slug));

        $response->assertUnauthorized();
    }
}
