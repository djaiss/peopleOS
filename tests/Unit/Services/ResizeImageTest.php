<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\ResizeImage;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

class ResizeImageTest extends TestCase
{
    #[Test]
    public function it_should_resize_image_to_specified_dimensions(): void
    {
        Storage::fake();
        $path = 'images/Ross_Geller.jpg';
        $resizedPath = 'images/Ross_Geller_64x64.webp';

        $image = ImageManager::imagick()->create(200, 200);
        Storage::put($path, $image->encode(new JpegEncoder()));

        $service = new ResizeImage(
            path: $path,
            maxWidth: 64,
            maxHeight: 64,
        );
        $service->execute();

        Storage::assertExists($resizedPath);

        $resizedImage = ImageManager::imagick()->read(Storage::get($resizedPath));
        $this->assertEquals(64, $resizedImage->width());
        $this->assertEquals(64, $resizedImage->height());
    }

    #[Test]
    public function it_should_handle_images_in_root_directory(): void
    {
        Storage::fake();
        $path = 'Ross_Geller.jpg';
        $resizedPath = 'Ross_Geller_64x64.webp';

        $image = ImageManager::imagick()->create(200, 200);
        Storage::put($path, $image->encode(new JpegEncoder()));

        $service = new ResizeImage(
            path: $path,
            maxWidth: 64,
            maxHeight: 64,
        );
        $service->execute();

        Storage::assertExists($resizedPath);
    }

    #[Test]
    public function it_should_throw_exception_when_original_file_doesnt_exist(): void
    {
        Storage::fake();
        $path = 'images/Ross_Geller.jpg';

        $service = new ResizeImage(
            path: $path,
            maxWidth: 64,
            maxHeight: 64,
        );

        $this->expectException(RuntimeException::class);
        $service->execute();
    }
}
