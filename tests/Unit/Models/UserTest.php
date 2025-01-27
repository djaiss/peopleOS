<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Log;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use ReflectionMethod;
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

    #[Test]
    public function it_generates_correct_initials_for_default_photo(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);

        // this is a protected method, so we need to use reflection to access it
        $method = new ReflectionMethod($user, 'defaultAvatar');
        $method->setAccessible(true);

        $this->assertEquals(
            'https://ui-avatars.com/api/?name=D+S&color=7F9CF5&background=EBF4FF&size=64',
            $method->invoke($user)
        );
    }

    #[Test]
    public function it_gets_the_avatar_if_there_is_no_profile_photo(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);

        $this->assertEquals(
            'https://ui-avatars.com/api/?name=D+S&color=7F9CF5&background=EBF4FF&size=64',
            $user->getAvatar(64)
        );
    }

    #[Test]
    public function it_gets_the_avatar_if_there_is_a_profile_photo(): void
    {
        config(['filesystems.default' => 'local']);
        $user = User::factory()->create();
        $user->profile_photo_path = 'path/to/photo.jpg';

        $this->assertEquals(
            '/storage/path/to/photo.jpg',
            $user->getAvatar(64)
        );
    }
}
