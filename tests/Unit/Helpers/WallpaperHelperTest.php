<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\Attributes\Test;
use App\Helpers\WallpaperHelper;
use Tests\TestCase;

class WallpaperHelperTest extends TestCase
{
    #[Test]
    public function it_returns_a_random_wallpaper(): void
    {
        $this->assertStringStartsWith(
            env('APP_URL').'/',
            WallpaperHelper::getRandomWallpaper()
        );
    }
}
