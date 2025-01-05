<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration;

use App\Livewire\Administration\ToggleDisplayNames;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToggleDisplayNamesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ToggleDisplayNames::class, [
                'userId' => $user->id,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_toggles_the_display_names(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(ToggleDisplayNames::class, [
                'userId' => $user->id,
            ])
            ->call('toggle');

        $this->assertFalse($user->refresh()->does_display_full_names);
    }
}
