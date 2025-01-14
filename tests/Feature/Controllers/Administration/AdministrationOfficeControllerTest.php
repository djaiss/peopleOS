<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationOfficeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function offices_can_be_listed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/offices');

        $response->assertStatus(200);
    }
}
