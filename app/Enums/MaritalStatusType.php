<?php

declare(strict_types=1);

namespace App\Enums;

enum MaritalStatusType: string
{
    case UNKNOWN = 'unknown';
    case SINGLE = 'single';
    case COUPLE = 'couple';
}
