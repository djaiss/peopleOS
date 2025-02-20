<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class UpdateMarketingTimestamps extends Command
{
    protected $signature = 'marketing:update-timestamps';

    protected $description = 'Update last modified timestamps for marketing pages';

    public function handle(): int
    {
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
                if ($timestamp) {
                    $timestamps[$relativePath] = $timestamp;
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
