<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationPersonalizationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_the_personalization_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/administration/personalization');

        $response->assertStatus(200);
        $response->assertViewIs('administration.personalization.index');
        $response->assertViewHas('taskCategories');
        $response->assertViewHas('genders');
        $response->assertViewHas('journalTemplates');
    }
}
