<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\File;

/**
 * This service is used to know the last modified timestamp for each marketing
 * page.
 * It loads all the files from the marketing directory and generates a config
 * that contains the last modified timestamp for each page.
 * The config file is named marketing-timestamps.php and is located in the config
 * directory.
 * The structure of the config is the following:
 *
 * return [
 *     'pages' => [
 *         'marketing/about' => '2021-01-01 00:00:00',
 *     ],
 * ];
 */
class ExtractMarketingTimestamps
{
    public function execute(): void
    {
        $this->updateTimestamps();
    }

    private function updateTimestamps(): void
    {
        $directoryPath = resource_path('views/marketing');
        $filesInfo = [];

        if (! File::isDirectory($directoryPath)) {
            return;
        }

        foreach (File::allFiles($directoryPath) as $file) {
            $relativePath = mb_rtrim(str_replace(
                [resource_path('views/'), '.blade.php', DIRECTORY_SEPARATOR],
                ['', '', '/'],
                $file->getPathname()
            ), '.');

            $filesInfo[$relativePath] = date('Y-m-d H:i:s', $this->getFileModifiedTime($file->getRealPath()));
        }

        $content = $this->generateConfigContent($filesInfo);
        File::put(config_path('marketing-timestamps.php'), $content);
    }

    public function getFileModifiedTime(string $path): int
    {
        return filemtime($path);
    }

    public function generateConfigContent(array $pages): string
    {
        $output = "<?php\n\nreturn [\n    'pages' => [\n";
        foreach ($pages as $path => $timestamp) {
            $output .= "        '{$path}' => '{$timestamp}',\n";
        }

        return $output."    ],\n];";
    }
}
