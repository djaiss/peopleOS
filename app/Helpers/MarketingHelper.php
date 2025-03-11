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
        $content = preg_replace('/@\w+/', '', (string) $content);

        // Remove HTML comments
        $content = preg_replace('/<!--[\s\S]*?-->/', '', (string) $content);

        // Remove PHP tags and their contents
        $content = preg_replace('/<\?php[\s\S]*?\?>/', '', (string) $content);

        // Remove HTML tags
        $content = strip_tags((string) $content);

        // Remove {{ }} and {!! !!} Blade expressions
        $content = preg_replace('/\{{2}[\s\S]*?\}{2}/', '', $content);
        $content = preg_replace('/\{!{2}[\s\S]*?!}\}/', '', (string) $content);

        // Remove extra whitespace
        $content = preg_replace('/\s+/', ' ', (string) $content);
        $content = trim((string) $content);

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
                'title' => 'Don Quixote',
                'author' => 'Miguel de Cervantes',
                'word_count' => 430000,
            ],
            [
                'title' => 'A Tale of Two Cities',
                'author' => 'Charles Dickens',
                'word_count' => 135000,
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'word_count' => 455000,
            ],
            [
                'title' => 'The Little Prince',
                'author' => 'Antoine de Saint-Exupéry',
                'word_count' => 16000,
            ],
            [
                'title' => "Harry Potter and the Philosopher's Stone",
                'author' => 'J.K. Rowling',
                'word_count' => 77000,
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'word_count' => 95000,
            ],
            [
                'title' => 'And Then There Were None',
                'author' => 'Agatha Christie',
                'word_count' => 66000,
            ],
            [
                'title' => 'Dream of the Red Chamber',
                'author' => 'Cao Xueqin',
                'word_count' => 845000,
            ],
            [
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'word_count' => 73000,
            ],
            [
                'title' => 'The Da Vinci Code',
                'author' => 'Dan Brown',
                'word_count' => 138000,
            ],
        ];

        $randomBook = Arr::random($popularBooks);

        $percentage = round($wordCount * 100 / $randomBook['word_count'], 2);

        return [
            'title' => $randomBook['title'],
            'author' => $randomBook['author'],
            'percentage' => $percentage,
        ];
    }

    public static function getRandomFact(): string
    {
        $facts = [
            "The first computer virus was created in 1983 and was called 'Elk Cloner.' It infected Apple II computers via floppy disks.",
            "The first webcam was used at the University of Cambridge to monitor a coffee pot, ensuring researchers wouldn't make a wasted trip for an empty pot.",
            "The original name of Windows was 'Interface Manager.' Thankfully, they went with something catchier.",
            'The first website ever created is still online. It was created by Tim Berners-Lee in 1991 and is about the World Wide Web project itself.',
            "The Firefox logo isn’t a fox. It’s a red panda. The name 'Firefox' is a nickname for the red panda.",
            'The first email ever sent was by Ray Tomlinson to himself in 1971. It was a test message containing random letters.',
            "In the 1950s, computers were referred to as 'electronic brains,' and programming was considered 'women's work.'",
            "The term 'bug' in software originated when a real moth caused a malfunction in the Harvard Mark II computer in 1947.",
            "Amazon was originally called 'Cadabra,' as in 'abracadabra.' It was changed because it sounded too much like 'cadaver.'",
            'The first computer mouse was made of wood. It was invented by Doug Engelbart in 1964.',
            'There are more than 1.5 billion websites on the internet, but less than 200 million are active.',
            'The QWERTY keyboard layout was designed to slow down typing to prevent mechanical typewriters from jamming.',
            "The first domain ever registered was Symbolics.com on March 15, 1985. It's still active today.",
            "The '@' symbol was chosen for email addresses because it was rarely used in computing, so it wouldn't conflict with existing protocols.",
            "The term 'surfing the internet' was coined in 1992 by librarian Jean Armour Polly, who wrote an article titled 'Surfing the Internet.'",
            "CAPTCHA stands for 'Completely Automated Public Turing test to tell Computers and Humans Apart.'",
            'The first 1GB hard drive, announced in 1980, weighed over 500 pounds and cost $40,000.',
            "Google was initially called 'Backrub' because the system checked backlinks to estimate the importance of sites.",
            "The first YouTube video, titled 'Me at the zoo,' was uploaded on April 23, 2005, by one of the platform's co-founders, Jawed Karim.",
            "The most common password in 2023 is still '123456,' followed closely by 'password.'",
            'The original Space Invaders game caused a shortage of 100-yen coins in Japan due to its popularity.',
            'The first computer programmer was Ada Lovelace in the 1840s, before computers were even built.',
            "The term 'spam' for unwanted emails comes from a Monty Python sketch where the word is repeatedly mentioned.",
            "The first search engine ever was called 'Archie,' created in 1990 to index FTP sites.",
            'The first online transaction was a sale of marijuana between Stanford and MIT students in the early 1970s, over ARPANET.',
            "The longest-running computer program is the 'Doomsday Flight' simulation, running since 1973 to test airline software.",
            "The '404 error' was named after a room at CERN where the original web servers were located.",
            "The first computer game ever created was 'Spacewar!' in 1962, developed by Steve Russell at MIT.",
            "The word 'robot' comes from the Czech word 'robota,' meaning 'forced labor' or 'drudgery.'",
            "The '@' symbol is called 'snail' in Italian and 'monkey's tail' in Dutch.",
        ];

        return Arr::random($facts);
    }

    public static function getStats(string $view): array
    {
        $wordCount = self::countWords($view);
        $readingTime = self::estimateReadingTime($wordCount);
        $comparison = self::compareBookLength($wordCount);
        $randomFact = self::getRandomFact();

        return [
            'word_count' => $wordCount,
            'reading_time' => $readingTime,
            'comparison' => $comparison,
            'random_fact' => $randomFact,
        ];
    }
}
