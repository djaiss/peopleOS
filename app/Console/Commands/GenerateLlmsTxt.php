<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateLlmsTxt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketing:llms-txt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate llms.txt for LLMs';

    public function handle(): int
    {
        $baseUrl = 'https://peopleos.cloud';
        $output = [];
        $output[] = '# PeopleOS Documentation';
        $output[] = '';
        $output[] = '> PeopleOS is an open-source personal CRM to help you remember the details that matter about your relationships.';
        $output[] = '';
        $output[] = '## Marketing Pages';
        $output[] = '';

        $bladeFiles = $this->getBladeFiles(resource_path('views/marketing'));
        foreach ($bladeFiles as $file) {
            $tags = $this->extractLlmsTags($file);
            if (!$tags['title']) {
                continue;
            }
            if (!$tags['route']) {
                continue;
            }
            if (!$tags['description']) {
                continue;
            }
            $url = Str::startsWith($tags['route'], 'http') ? $tags['route'] : $baseUrl . $tags['route'];
            $output[] = "- [{$tags['title']}]({$url}): {$tags['description']}";
        }

        File::put(public_path('llms.txt'), implode("\n", $output) . "\n");
        $this->info('llms.txt generated successfully.');
        return 0;
    }

    private function getBladeFiles(string $dir): array
    {
        $files = [];
        foreach (File::allFiles($dir) as $file) {
            if (Str::endsWith($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }
        return $files;
    }

    private function extractLlmsTags(string $file): array
    {
        $title = null;
        $route = null;
        $description = null;
        $lines = File::lines($file);
        foreach ($lines as $line) {
            if (Str::contains($line, '@llms-title:')) {
                $title = mb_trim(Str::after($line, '@llms-title:'), " -\n\r{}>");
            }
            if (Str::contains($line, '@llms-route:')) {
                $route = mb_trim(Str::after($line, '@llms-route:'), " -\n\r{}>");
            }
            if (Str::contains($line, '@llms-description:')) {
                $description = mb_trim(Str::after($line, '@llms-description:'), " -\n\r{}>");
            }
        }
        return [
            'title' => $title,
            'route' => $route,
            'description' => $description,
        ];
    }
}
