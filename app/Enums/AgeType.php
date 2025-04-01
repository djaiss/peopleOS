<?php

declare(strict_types=1);

namespace App\Enums;

enum AgeType: string
{
    case EXACT = 'exact';
    case ESTIMATED = 'estimated';
    case BRACKET = 'bracket';
}
