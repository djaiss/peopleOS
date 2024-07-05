<?php

namespace Tests\Unit\Services;

use App\Models\Account;
use App\Models\User;
use App\Services\UpdateNameOrderPreferences;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UpdateNameOrderPreferencesTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function it_stores_the_name_order_preference(): void
    {
        $this->executeService('%name%');
    }

    #[Test]
    public function it_fails_if_name_order_has_no_closing_percent_symbol(): void
    {
        $this->expectException(Exception::class);
        $this->executeService('%');
    }

    private function executeService(string $nameOrder): void
    {
        $user = User::factory()->create();
        $user = (new UpdateNameOrderPreferences(
            user: $user,
            nameOrder: $nameOrder,
        ))->execute();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name_order' => $nameOrder,
        ]);

        $this->assertInstanceOf(
            User::class,
            $user
        );
    }
}
