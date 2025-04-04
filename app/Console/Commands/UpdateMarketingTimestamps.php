<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

/**
 * This command updates the last modified timestamps for all marketing pages.
 * It uses the git log command to get the last commit date for each file.
 * It stores both the original date format (with slashes) and the date format
 * with dots (for compatibility with the `config/marketing-timestamps.php` file).
 * That way we can use the same format for the last modified date in the blade file.
 */
class UpdateMarketingTimestamps extends Command
{
    protected $signature = 'marketing:update-timestamps';

    protected $description = 'Update last modified timestamps for marketing pages';

    public function handle(): int
    {
        $marketingPages =$this->getMarketingPages();

        $this->info('Found ' . count($marketingPages) . ' marketing pages.');

        foreach ($marketingPages as $marketingPage) {
            $this->info('Updating timestamp for ' . $marketingPage->url);

            $this->processMarketingPage($marketingPage);
        }

        $marketingPath = resource_path('views/marketing');
        $timestamps = [];

        // Get all blade files recursively
        $files = File::allFiles($marketingPath);

        foreach ($files as $file) {
            // Get relative path from views directory
            $relativePath = str_replace(
                [resource_path('views/'), '.blade.php'],
                ['', ''],
                $file->getPathname()
            );

            // Get last commit date for this file
            $process = new Process([
                'git',
                'log',
                '-1',
                '--format=%aI',
                '--',
                $file->getPathname(),
            ]);

            $process->run();

            if ($process->isSuccessful()) {
                $timestamp = trim($process->getOutput());
                if ($timestamp !== '' && $timestamp !== '0') {
                    // Store both formats - with slashes and with dots
                    $timestamps[$relativePath] = $timestamp;
                    $timestamps[str_replace('/', '.', $relativePath)] = $timestamp;
                }
            }
        }

        // Generate config file content
        $content = "<?php\n\nreturn [\n    'pages' => [\n";
        foreach ($timestamps as $page => $timestamp) {
            $content .= "        '{$page}' => '{$timestamp}',\n";
        }
        $content .= "    ],\n];";

        // Write to config file
        File::put(config_path('marketing-timestamps.php'), $content);

        $this->info('Marketing page timestamps have been updated.');

        return Command::SUCCESS;
    }
}
