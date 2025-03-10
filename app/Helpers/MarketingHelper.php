<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

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
}
