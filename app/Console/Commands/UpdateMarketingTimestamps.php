<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ExtractMarketingTimestamps;
use Illuminate\Console\Command;

/**
 * This command updates the last modified timestamps for all marketing pages.
 */
class UpdateMarketingTimestamps extends Command
{
    protected $signature = 'marketing:update-timestamps';

    protected $description = 'Update last modified timestamps for marketing pages';

    public function handle(): void
    {
        (new ExtractMarketingTimestamps())->execute();
        $this->info('Marketing page timestamps updated.');
    }
}
