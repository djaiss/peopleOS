<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use App\Helpers\MarketingHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MarketingHelperTest extends TestCase
{
    #[Test]
    public function it_returns_carbon_instance_when_timestamp_exists()
    {
        // Arrange
        $view = 'marketing/landing';
        $expectedDate = '2023-05-15 10:00:00';
        Config::set('marketing-timestamps.pages.marketing/landing', $expectedDate);

        // Act
        $result = MarketingHelper::getLastModified($view);

        // Assert
        $this->assertInstanceOf(Carbon::class, $result);
        $this->assertEquals($expectedDate, $result->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function it_returns_null_when_timestamp_does_not_exist()
    {
        // Arrange
        $view = 'marketing/nonexistent';
        Config::set('marketing-timestamps.pages.marketing/nonexistent', null);

        // Act
        $result = MarketingHelper::getLastModified($view);

        // Assert
        $this->assertNull($result);
    }

    #[Test]
    public function it_returns_word_count_when_file_exists()
    {
        // Arrange
        $view = 'test.word-count';
        $content = 'This is a test file with 8 words.';
        $filePath = resource_path('views/test/word-count.blade.php');

        // Create test directory if it doesn't exist
        if (! file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        // Create test file
        file_put_contents($filePath, $content);

        // Act
        $result = MarketingHelper::countWords($view);

        // Assert
        $this->assertEquals(7, $result);

        // Cleanup
        unlink($filePath);
        if (is_dir(dirname($filePath)) && count(scandir(dirname($filePath))) <= 2) {
            rmdir(dirname($filePath));
        }
    }

    #[Test]
    public function it_handles_blade_syntax_when_counting_words()
    {
        // Arrange
        $view = 'test.blade-syntax';
        $content = '@if(true) These five words should be counted @endif {{ "These four should be removed" }}';
        $filePath = resource_path('views/test/blade-syntax.blade.php');

        // Create test directory if it doesn't exist
        if (! file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        // Create test file
        file_put_contents($filePath, $content);

        // Act
        $result = MarketingHelper::countWords($view);

        // Assert
        $this->assertEquals(6, $result);

        // Cleanup
        unlink($filePath);
        if (is_dir(dirname($filePath)) && count(scandir(dirname($filePath))) <= 2) {
            rmdir(dirname($filePath));
        }
    }

    #[Test]
    public function it_returns_zero_when_file_does_not_exist()
    {
        // Arrange
        $view = 'nonexistent.view';

        // Act
        $result = MarketingHelper::countWords($view);

        // Assert
        $this->assertEquals(0, $result);
    }

    #[Test]
    public function it_estimates_reading_time_correctly()
    {
        // Test cases with wordsPerMinute = 225 (default)
        $this->assertEquals(1, MarketingHelper::estimateReadingTime(200));
        $this->assertEquals(2, MarketingHelper::estimateReadingTime(300));
        $this->assertEquals(0, MarketingHelper::estimateReadingTime(0));

        // Test with custom words per minute
        $this->assertEquals(2, MarketingHelper::estimateReadingTime(150, 100));
    }

    #[Test]
    public function it_compares_book_length_correctly()
    {
        // Act
        $result = MarketingHelper::compareBookLength(50000);

        // Assert
        $this->assertArrayHasKeys($result, ['title', 'author', 'percentage']);
        $this->assertIsString($result['title']);
        $this->assertIsString($result['author']);
        $this->assertIsFloat($result['percentage']);
    }

    #[Test]
    public function it_returns_random_fact()
    {
        // Act
        $fact = MarketingHelper::getRandomFact();

        // Assert
        $this->assertIsString($fact);
        $this->assertNotEmpty($fact);
    }

    #[Test]
    public function it_returns_complete_stats()
    {
        // Arrange
        $view = 'test.stats';
        $content = 'This is a test file with some content.';
        $filePath = resource_path('views/test/stats.blade.php');

        if (! file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }
        file_put_contents($filePath, $content);

        // Act
        $stats = MarketingHelper::getStats($view);

        // Assert
        $this->assertArrayHasKeys($stats, [
            'word_count',
            'reading_time',
            'comparison',
            'random_fact',
        ]);
        $this->assertEquals(8, $stats['word_count']);
        $this->assertEquals(1, $stats['reading_time']);
        $this->assertArrayHasKeys($stats['comparison'], ['title', 'author', 'percentage']);
        $this->assertIsString($stats['random_fact']);
        $this->assertNotEmpty($stats['random_fact']);

        // Cleanup
        unlink($filePath);
        if (is_dir(dirname($filePath)) && count(scandir(dirname($filePath))) <= 2) {
            rmdir(dirname($filePath));
        }
    }
}
