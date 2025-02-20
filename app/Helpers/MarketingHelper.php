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
}
