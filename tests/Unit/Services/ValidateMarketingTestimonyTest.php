<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Enums\MarketingTestimonyStatus;
use App\Models\MarketingTestimony;
use App\Models\User;
use App\Services\ValidateMarketingTestimony;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidateMarketingTestimonyTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_validates_a_marketing_testimony_as_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => true,
        ]);
        $testimony = MarketingTestimony::factory()->create([
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $updatedTestimony = (new ValidateMarketingTestimony(
            user: $user,
            testimony: $testimony,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimony->id,
            'status' => MarketingTestimonyStatus::APPROVED->value,
        ]);

        $this->assertEquals(
            MarketingTestimonyStatus::APPROVED->value,
            $updatedTestimony->status
        );
    }

    #[Test]
    public function it_fails_if_user_is_not_instance_administrator(): void
    {
        $user = User::factory()->create([
            'is_instance_admin' => false,
            'first_name' => 'Gunther',
        ]);
        $testimony = MarketingTestimony::factory()->create([
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User must be an instance administrator to validate a testimony.');

        (new ValidateMarketingTestimony(
            user: $user,
            testimony: $testimony,
        ))->execute();

        $this->assertDatabaseHas('marketing_testimonies', [
            'id' => $testimony->id,
            'status' => MarketingTestimonyStatus::PENDING->value,
        ]);
    }
}
