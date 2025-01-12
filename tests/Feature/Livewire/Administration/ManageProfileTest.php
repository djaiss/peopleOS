<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration;

use App\Livewire\Administration\ManageProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageProfileTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Jim',
            'last_name' => 'Halpert',
            'nickname' => 'Big Tuna',
            'email' => 'jim.halpert@dundermifflin.com',
            'born_at' => '1979-10-01',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageProfile::class);

        $component->assertOk();

        $component->assertSet('first_name', 'Jim')
            ->assertSet('last_name', 'Halpert')
            ->assertSet('nickname', 'Big Tuna')
            ->assertSet('email', 'jim.halpert@dundermifflin.com')
            ->assertSet('born_at', '10-01-1979');
    }

    #[Test]
    public function it_can_update_profile(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
            'email' => 'dwight.schrute@dundermifflin.com',
            'nickname' => 'Assistant Regional Manager',
            'born_at' => '1970-01-20',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageProfile::class)
            ->set('first_name', 'Michael')
            ->set('last_name', 'Scott')
            ->set('email', 'michael.scott@dundermifflin.com')
            ->set('nickname', 'World\'s Best Boss')
            ->set('born_at', '03/15/1965')
            ->call('update');

        $component->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'email' => 'michael.scott@dundermifflin.com',
            'nickname' => 'World\'s Best Boss',
            'born_at' => '1965-03-15 00:00:00',
        ]);
    }

    #[Test]
    public function it_validates_required_fields(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageProfile::class)
            ->set('first_name', '')
            ->set('last_name', '')
            ->set('email', '')
            ->call('update');

        $component->assertHasErrors([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);
    }

    #[Test]
    public function it_validates_email_format(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(ManageProfile::class)
            ->set('email', 'not-an-email')
            ->call('update');

        $component->assertHasErrors(['email' => 'email']);
    }

    #[Test]
    public function it_validates_unique_email(): void
    {
        $user = User::factory()->create([
            'email' => 'michael.scott@dundermifflin.com',
        ]);

        User::factory()->create([
            'email' => 'dwight.schrute@dundermifflin.com',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageProfile::class)
            ->set('email', 'dwight.schrute@dundermifflin.com')
            ->call('update');

        $component->assertHasErrors(['email' => 'unique']);
    }
}
