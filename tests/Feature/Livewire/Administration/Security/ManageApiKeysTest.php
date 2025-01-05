<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration\Security;

use App\Livewire\Administration\Security\ManageApiKeys;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageApiKeysTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageApiKeys::class, [
                'userId' => $user->id,
            ]);

        $component->assertOk();
    }

    #[Test]
    public function it_can_toggle_add_mode(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageApiKeys::class, [
                'userId' => $user->id,
            ]);

        $component->assertSet('addMode', false);

        $component->call('toggleAddMode');

        $component->assertSet('addMode', true);
    }

    #[Test]
    public function it_can_create_an_api_key(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageApiKeys::class, [
                'userId' => $user->id,
            ]);

        $component->set('label', 'Test API Key')
            ->call('store');

        $component->assertSet('label', '');

        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => 'Test API Key',
            'tokenable_id' => $user->id,
            'tokenable_type' => User::class,
        ]);
    }

    #[Test]
    public function it_validates_label_when_creating_api_key(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageApiKeys::class, [
                'userId' => $user->id,
            ]);

        $component->set('label', '')
            ->call('store')
            ->assertHasErrors(['label' => 'required']);

        $component->set('label', 'ab')
            ->call('store')
            ->assertHasErrors(['label' => 'min']);

        $component->set('label', str_repeat('a', 256))
            ->call('store')
            ->assertHasErrors(['label' => 'max']);
    }

    #[Test]
    public function it_can_delete_an_api_key(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test API Key');

        $component = Livewire::actingAs($user)
            ->test(ManageApiKeys::class, [
                'userId' => $user->id,
            ]);

        $component->call('delete', $token->accessToken->id);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'id' => $token->accessToken->id,
        ]);
    }
}
