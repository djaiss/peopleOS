<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration\Users;

use App\Livewire\Administration\Users\InviteUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InviteUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(InviteUser::class);

        $component->assertOk();
    }

    #[Test]
    public function it_invites_a_user(): void
    {
        Queue::fake();
        Mail::fake();

        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(InviteUser::class)
            ->set('email', 'jim.halpert@dundermifflin.com')
            ->call('store')
            ->assertDispatched('user-invited')
            ->assertDispatched('store-complete');

        $component->assertHasNoErrors();
        $component->assertSet('email', '');

        $this->assertDatabaseHas('users', [
            'email' => 'jim.halpert@dundermifflin.com',
            'account_id' => $user->account_id,
        ]);
    }

    #[Test]
    public function it_validates_email(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(InviteUser::class);

        $component->set('email', '')
            ->call('store')
            ->assertHasErrors(['email' => 'required']);

        $component->set('email', 'not-an-email')
            ->call('store')
            ->assertHasErrors(['email' => 'email']);

        User::factory()->create(['email' => 'jim.halpert@dundermifflin.com']);

        $component->set('email', 'jim.halpert@dundermifflin.com')
            ->call('store')
            ->assertHasErrors(['email' => 'unique']);
    }
}
