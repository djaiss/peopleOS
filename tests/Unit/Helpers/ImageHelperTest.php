<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\ImageHelper;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImageHelperTest extends TestCase
{
    #[Test]
    public function it_should_generate_variant_path_for_image_in_subdirectory(): void
    {
        $path = 'images/Ross_Geller.jpg';
        $size = 64;

        $variantPath = ImageHelper::getImageVariantPath($path, $size);

        $this->assertEquals(
            'images/Ross_Geller_64x64.webp',
            $variantPath
        );
    }

    #[Test]
    public function it_should_generate_variant_path_for_image_in_root_directory(): void
    {
        $path = 'Ross_Geller.jpg';
        $size = 128;

        $variantPath = ImageHelper::getImageVariantPath($path, $size);

        $this->assertEquals(
            'Ross_Geller_128x128.webp',
            $variantPath
        );
    }

    #[Test]
    public function it_should_handle_different_image_extensions(): void
    {
        $path = 'images/Ross_Geller.png';
        $size = 256;

        $variantPath = ImageHelper::getImageVariantPath($path, $size);

        $this->assertEquals(
            'images/Ross_Geller_256x256.webp',
            $variantPath
        );
    }

    #[Test]
    public function it_should_handle_nested_directories(): void
    {
        $path = 'images/avatars/Ross_Geller.jpg';
        $size = 64;

        $variantPath = ImageHelper::getImageVariantPath($path, $size);

        $this->assertEquals(
            'images/avatars/Ross_Geller_64x64.webp',
            $variantPath
        );
    }
}
