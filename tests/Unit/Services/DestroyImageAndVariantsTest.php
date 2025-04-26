<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\DestroyImageAndVariants;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyImageAndVariantsTest extends TestCase
{
    #[Test]
    public function it_should_delete_original_file_and_all_variants(): void
    {
        Storage::fake();
        $originalPath = 'images/Ross_Geller.jpg';
        $variant64 = 'images/Ross_Geller_64x64.webp';
        $variant128 = 'images/Ross_Geller_128x128.webp';
        $variant256 = 'images/Ross_Geller_256x256.webp';

        Storage::put($originalPath, 'original content');
        Storage::put($variant64, '64x64 content');
        Storage::put($variant128, '128x128 content');

        $service = new DestroyImageAndVariants($originalPath);
        $service->execute();

        Storage::assertMissing($originalPath);
        Storage::assertMissing($variant64);
        Storage::assertMissing($variant128);
    }

    #[Test]
    public function it_should_handle_files_in_root_directory(): void
    {
        Storage::fake();
        $originalPath = 'Ross_Geller.jpg';
        $variant64 = 'Ross_Geller_64x64.webp';
        $variant128 = 'Ross_Geller_128x128.webp';

        Storage::put($originalPath, 'original content');
        Storage::put($variant64, '64x64 content');
        Storage::put($variant128, '128x128 content');

        $service = new DestroyImageAndVariants($originalPath);
        $service->execute();

        Storage::assertMissing($originalPath);
        Storage::assertMissing($variant64);
        Storage::assertMissing($variant128);
    }

    #[Test]
    public function it_should_not_fail_when_variants_dont_exist(): void
    {
        Storage::fake();
        $originalPath = 'images/Ross_Geller.jpg';

        Storage::put($originalPath, 'original content');

        $service = new DestroyImageAndVariants($originalPath);
        $service->execute();

        Storage::assertMissing($originalPath);
    }
}
