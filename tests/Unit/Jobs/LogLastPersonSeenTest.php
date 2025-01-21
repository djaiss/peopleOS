<?php

declare(strict_types=1);

namespace Tests\Unit\Jobs;

use App\Jobs\LogLastPersonSeen;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LogLastPersonSeenTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_logs_the_last_person_seen_by_a_user(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        LogLastPersonSeen::dispatch($user, $person);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'last_person_seen_id' => $person->id,
        ]);
    }

    #[Test]
    public function it_updates_existing_last_person_seen(): void
    {
        $user = User::factory()->create();
        $firstPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);
        $secondPerson = Person::factory()->create([
            'account_id' => $user->account_id,
        ]);

        // Set initial last person seen
        LogLastPersonSeen::dispatch($user, $firstPerson);
        $this->assertEquals($firstPerson->id, $user->refresh()->last_person_seen_id);

        // Update to new person
        LogLastPersonSeen::dispatch($user, $secondPerson);
        $this->assertEquals($secondPerson->id, $user->refresh()->last_person_seen_id);
    }
}
