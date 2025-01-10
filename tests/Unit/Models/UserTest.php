<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Log;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $dwight = User::factory()->create();

        $this->assertTrue($dwight->account()->exists());
    }

    #[Test]
    public function it_has_many_logs(): void
    {
        $dwight = User::factory()->create();
        Log::factory()->create([
            'user_id' => $dwight->id,
        ]);

        $this->assertTrue($dwight->logs()->exists());
    }

    #[Test]
    public function it_belongs_to_many_teams(): void
    {
        $dwight = User::factory()->create();
        $team = Team::factory()->create();
        $dwight->teams()->attach($team);
        $this->assertTrue($dwight->teams()->exists());
    }

    #[Test]
    public function it_gets_the_name(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);

        $this->assertEquals(
            'Dwight Schrute',
            $user->name
        );
    }
}
