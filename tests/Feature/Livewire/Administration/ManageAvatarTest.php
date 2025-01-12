<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Administration;

use App\Livewire\Administration\ManageAvatar;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageAvatarTest extends TestCase
{
    #[Test]
    public function the_component_renders(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageAvatar::class);

        $component->assertOk();
    }

    #[Test]
    public function it_can_upload_a_new_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'first_name' => 'Dwight',
            'last_name' => 'Schrute',
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $component = Livewire::actingAs($user)
            ->test(ManageAvatar::class)
            ->set('photo', $file)
            ->call('store');

        $component->assertHasNoErrors()
            ->assertDispatched('avatar-updated');

        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    #[Test]
    public function it_validates_photo_upload(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Jim',
            'last_name' => 'Halpert',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageAvatar::class);

        // Test non-image file
        $file = UploadedFile::fake()->create('document.pdf', 100);
        $component->set('photo', $file)
            ->call('store')
            ->assertHasErrors(['photo' => 'image']);

        // Test file too large (over 2MB)
        $file = UploadedFile::fake()->image('large-avatar.jpg')->size(2001);
        $component->set('photo', $file)
            ->call('store')
            ->assertHasErrors(['photo' => 'max']);
    }

    #[Test]
    public function it_refreshes_avatar_url_after_upload(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'first_name' => 'Pam',
            'last_name' => 'Beesly',
        ]);

        $oldAvatarUrl = $user->profile_photo_url;
        $file = UploadedFile::fake()->image('avatar.jpg');

        $component = Livewire::actingAs($user)
            ->test(ManageAvatar::class)
            ->set('photo', $file)
            ->call('store');

        $this->assertNotEquals($oldAvatarUrl, $component->get('avatarUrl'));
    }
}
