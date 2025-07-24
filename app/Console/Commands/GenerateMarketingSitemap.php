<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\GenerateMarketingSitemap as GenerateMarketingSitemapService;
use Illuminate\Console\Command;

/**
 * This command generates a sitemap for all marketing routes.
 */
class GenerateMarketingSitemap extends Command
{
    protected $signature = 'marketing:generate-sitemap';

    protected $description = 'Generate sitemap for marketing routes';

    public function handle(): void
    {
        (new GenerateMarketingSitemapService())->execute();

        $this->info('Marketing sitemap generated successfully at public/sitemap.xml');
    }
}
