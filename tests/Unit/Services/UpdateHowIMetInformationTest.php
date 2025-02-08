<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Jobs\LogUserAction;
use App\Jobs\UpdateUserLastActivityDate;
use App\Models\Account;
use App\Models\Person;
use App\Models\User;
use App\Services\UpdateHowIMetInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UpdateHowIMetInformationTest extends TestCase
{
    use DatabaseTransactions;

    private Account $account;

    private User $user;

    private Person $person;

    /** @test */
    public function it_updates_how_i_met_information(): void
    {
        Queue::fake();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $howIMet = 'Met at Central Perk coffee shop';
        $location = 'New York City';
        $firstImpressions = 'She was wearing a wedding dress';
        $shown = true;

        $service = new UpdateHowIMetInformation(
            user: $this->user,
            person: $this->person,
            howIMet: $howIMet,
            howIMetLocation: $location,
            howIMetFirstImpressions: $firstImpressions,
            howIMetShown: $shown,
        );

        $person = $service->execute();

        $this->assertEquals($howIMet, $person->how_we_met);
        $this->assertEquals($location, $person->how_we_met_location);
        $this->assertEquals($firstImpressions, $person->how_we_met_first_impressions);
        $this->assertTrue($person->how_we_met_shown);

        Queue::assertPushed(UpdateUserLastActivityDate::class, function ($job) {
            return $job->user->id === $this->user->id;
        });

        Queue::assertPushed(LogUserAction::class, function ($job) {
            return $job->user->id === $this->user->id &&
                $job->action === 'how_i_met_information_update';
        });
    }

    /** @test */
    public function it_updates_how_i_met_information_with_null_values(): void
    {
        Queue::fake();

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $service = new UpdateHowIMetInformation(
            user: $this->user,
            person: $this->person,
            howIMet: null,
            howIMetLocation: null,
            howIMetFirstImpressions: null,
            howIMetShown: false,
        );

        $person = $service->execute();

        $this->assertNull($person->how_we_met);
        $this->assertNull($person->how_we_met_location);
        $this->assertNull($person->how_we_met_first_impressions);
        $this->assertFalse($person->how_we_met_shown);
    }

    /** @test */
    public function it_fails_if_user_doesnt_belong_to_the_same_account(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->account = Account::factory()->create();
        $this->user = User::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->person = Person::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $otherAccount = Account::factory()->create();
        $otherUser = User::factory()->create([
            'account_id' => $otherAccount->id,
        ]);

        $service = new UpdateHowIMetInformation(
            user: $otherUser,
            person: $this->person,
            howIMet: 'Met at Central Perk',
            howIMetLocation: 'New York',
            howIMetFirstImpressions: 'She was wearing a wedding dress',
            howIMetShown: true,
        );

        $service->execute();
    }
}
