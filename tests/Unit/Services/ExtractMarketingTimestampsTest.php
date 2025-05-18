<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\ExtractMarketingTimestamps;
use Illuminate\Support\Facades\File;
use Mockery;
use Tests\TestCase;

class ExtractMarketingTimestampsTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_it_generates_timestamp_file_for_marketing_pages(): void
    {
        $file1 = Mockery::mock();
        $file1->shouldReceive('getPathname')->andReturn(resource_path('views/marketing/about.blade.php'));
        $file1->shouldReceive('getRealPath')->andReturn(resource_path('views/marketing/about.blade.php'));

        $file2 = Mockery::mock();
        $file2->shouldReceive('getPathname')->andReturn(resource_path('views/marketing/contact.blade.php'));
        $file2->shouldReceive('getRealPath')->andReturn(resource_path('views/marketing/contact.blade.php'));

        $fakeFiles = [$file1, $file2];

        $aboutTime = now()->timestamp;
        $contactTime = now()->subDay()->timestamp;

        File::shouldReceive('isDirectory')
            ->once()
            ->with(resource_path('views/marketing'))
            ->andReturn(true);

        File::shouldReceive('allFiles')
            ->once()
            ->with(resource_path('views/marketing'))
            ->andReturn($fakeFiles);

        File::shouldReceive('put')
            ->once()
            ->withArgs(function ($path, $content) use ($aboutTime, $contactTime) {
                $this->assertEquals(config_path('marketing-timestamps.php'), $path);
                $this->assertStringContainsString('marketing/about', $content);
                $this->assertStringContainsString(date('Y-m-d H:i:s', $aboutTime), $content);
                $this->assertStringContainsString('marketing/contact', $content);
                $this->assertStringContainsString(date('Y-m-d H:i:s', $contactTime), $content);

                return true;
            });

        $service = Mockery::mock(ExtractMarketingTimestamps::class)->makePartial();
        $service->shouldReceive('getFileModifiedTime')->andReturnUsing(function ($path) use ($aboutTime, $contactTime) {
            return str_contains($path, 'about') ? $aboutTime : $contactTime;
        });

        $service->execute();
    }
}
