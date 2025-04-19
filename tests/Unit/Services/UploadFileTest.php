<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\UploadFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    use WithFaker;

    #[Test]
    public function it_should_upload_a_file(): void
    {
        Storage::fake('local');
        config(['filesystems.default' => 'local']);

        $file = UploadedFile::fake()->image('joey.jpg');
        $path = (new UploadFile(
            file: $file,
            folderName: 'avatars',
        ))->execute();

        $this->assertTrue(Storage::disk('local')->exists($path));
        $this->assertStringStartsWith('avatars/', $path);
    }
}
