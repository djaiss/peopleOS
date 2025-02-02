<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Administration;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdministrationAvatarControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_update_their_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'first_name' => 'Ross',
            'last_name' => 'Geller',
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/avatar', [
                'photo' => $file,
            ]);

        $response->assertRedirect('/administration');
    }

    #[Test]
    public function user_cannot_upload_non_image_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'first_name' => 'Chandler',
            'last_name' => 'Bing',
        ]);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/avatar', [
                'photo' => $file,
            ]);

        $response->assertInvalid(['photo' => 'The photo field must be an image.']);

        // Ensure no file was stored
        Storage::disk('public')->assertDirectoryEmpty('avatars');
    }

    #[Test]
    public function user_cannot_upload_file_larger_than_2mb(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'first_name' => 'Monica',
            'last_name' => 'Geller',
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg')->size(2001);

        $response = $this->actingAs($user)
            ->from('/administration')
            ->put('/administration/avatar', [
                'photo' => $file,
            ]);

        $response->assertInvalid(['photo' => 'The photo field must not be greater than 2000 kilobytes.']);

        // Ensure no file was stored
        Storage::disk('public')->assertDirectoryEmpty('avatars');
    }
}
