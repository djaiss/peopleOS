<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Log;
use App\Models\User;
use App\Services\GetSubsetOfLogs;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetSubsetOfLogsTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_returns_a_subset_of_logs(): void
    {
        Queue::fake();
        Carbon::setTestNow(Carbon::create(2018, 1, 1));

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        Log::factory()->create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'action' => 'profile_update',
            'description' => 'Updated their profile',
        ]);

        $array = (new GetSubsetOfLogs())->execute();

        $this->assertArrayHasKeys($array, ['logs', 'has_more_logs']);
        $this->assertArrayHasKeys($array['logs'][0], ['user', 'action', 'description', 'created_at']);

        $this->assertCount(1, $array['logs']);
        $this->assertEquals([
            'user' => [
                'name' => 'Ross Geller',
            ],
            'action' => 'profile_update',
            'description' => 'Updated their profile',
            'created_at' => '1 year ago',
        ], $array['logs'][0]);

        $this->assertFalse($array['has_more_logs']);
    }
}
