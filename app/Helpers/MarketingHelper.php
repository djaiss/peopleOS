<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

class MarketingHelper
{
    public static function getLastModified(string $view): ?Carbon
    {
        $timestamp = config("marketing-timestamps.pages.{$view}");

        return $timestamp ? Carbon::parse($timestamp) : null;
    }
}
