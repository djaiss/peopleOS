<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Log;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LogTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_belongs_to_an_account(): void
    {
        $log = Log::factory()->create();

        $this->assertTrue($log->account()->exists());
    }

    #[Test]
    public function it_belongs_to_a_user(): void
    {
        $log = Log::factory()->create();

        $this->assertTrue($log->user()->exists());
    }

    #[Test]
    public function it_has_a_name(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);
        $log = Log::factory()->create([
            'user_id' => $user->id,
            'user_name' => 'Jim Halpert',
        ]);

        $this->assertEquals('Dwight Schrute', $log->name);

        $log->user = null;
        $this->assertEquals('Jim Halpert', $log->name);
    }
}
