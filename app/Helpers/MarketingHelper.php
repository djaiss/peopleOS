<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class MarketingHelper
{
    public static function getLastModified(string $view): ?Carbon
    {
        // Convert route name (dots) to file path (slashes)
        $viewPath = str_replace('.', '/', $view);

        $timestamp = config("marketing-timestamps.pages.{$viewPath}");

        return $timestamp ? Carbon::parse($timestamp) : null;
    }

    /**
     * Count the words in a view file.
     */
    public static function countWords(string $view): int
    {
        // Convert route name (dots) to file path (slashes)
        $viewPath = str_replace('.', '/', $view);
        $fullPath = resource_path("views/{$viewPath}.blade.php");

        if (! file_exists($fullPath)) {
            return 0;
        }

        $content = file_get_contents($fullPath);

        // Remove Blade syntax (@if, @foreach, etc)
        $content = preg_replace('/@\w+\s*\([^)]*\)/', '', $content);
        $content = preg_replace('/@\w+/', '', $content);

        // Remove HTML comments
        $content = preg_replace('/<!--[\s\S]*?-->/', '', $content);

        // Remove PHP tags and their contents
        $content = preg_replace('/<\?php[\s\S]*?\?>/', '', $content);

        // Remove HTML tags
        $content = strip_tags($content);

        // Remove {{ }} and {!! !!} Blade expressions
        $content = preg_replace('/\{{2}[\s\S]*?\}{2}/', '', $content);
        $content = preg_replace('/\{!{2}[\s\S]*?!}\}/', '', $content);

        // Remove extra whitespace
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        // Count words
        return str_word_count($content);
    }

    /**
     * Estimate reading time in minutes based on word count.
     *
     * Uses average reading speed of 200-250 words per minute.
     */
    public static function estimateReadingTime(int $wordCount, int $wordsPerMinute = 225): int
    {
        if ($wordCount <= 0) {
            return 0;
        }

        return (int) ceil($wordCount / $wordsPerMinute);
    }

    /**
     * Compare reading time to popular books.
     */
    public static function compareBookLength(int $wordCount): array
    {
        $popularBooks = [
            [
                "title" => "Don Quixote",
                "author" => "Miguel de Cervantes",
                "word_count" => 430000
            ],
            [
                "title" => "A Tale of Two Cities",
                "author" => "Charles Dickens",
                "word_count" => 135000
            ],
            [
                "title" => "The Lord of the Rings",
                "author" => "J.R.R. Tolkien",
                "word_count" => 455000
            ],
            [
                "title" => "The Little Prince",
                "author" => "Antoine de Saint-Exupéry",
                "word_count" => 16000
            ],
            [
                "title" => "Harry Potter and the Philosopher's Stone",
                "author" => "J.K. Rowling",
                "word_count" => 77000
            ],
            [
                "title" => "The Hobbit",
                "author" => "J.R.R. Tolkien",
                "word_count" => 95000
            ],
            [
                "title" => "And Then There Were None",
                "author" => "Agatha Christie",
                "word_count" => 66000
            ],
            [
                "title" => "Dream of the Red Chamber",
                "author" => "Cao Xueqin",
                "word_count" => 845000
            ],
            [
                "title" => "The Catcher in the Rye",
                "author" => "J.D. Salinger",
                "word_count" => 73000
            ],
            [
                "title" => "The Da Vinci Code",
                "author" => "Dan Brown",
                "word_count" => 138000
            ]
        ];

        $randomBook = Arr::random($popularBooks);

        $percentage = round($wordCount * 100 / $randomBook['word_count'], 2);

        return [
            'title' => $randomBook['title'],
            'author' => $randomBook['author'],
            'percentage' => $percentage,
        ];
    }

    public static function getStats(string $view): array
    {
        $wordCount = self::countWords($view);
        $readingTime = self::estimateReadingTime($wordCount);
        $comparison = self::compareBookLength($wordCount);

        return [
            'word_count' => $wordCount,
            'reading_time' => $readingTime,
            'comparison' => $comparison,
        ];
    }
}
