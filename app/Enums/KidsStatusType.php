<?php

declare(strict_types=1);

namespace App\Enums;

enum KidsStatusType: string
{
    case UNKNOWN = 'unknown';
    case NO_KIDS = 'no_kids';
    case MAYBE_KIDS = 'maybe_kids';
    case HAS_KIDS = 'has_kids';
}
