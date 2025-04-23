<?php

declare(strict_types=1);

namespace App\Enums;

enum MoodType: string
{
    case VERY_UNPLEASANT = 'very_unpleasant';
    case UNPLEASANT = 'unpleasant';
    case SLIGHTLY_UNPLEASANT = 'slightly_unpleasant';
    case NEUTRAL = 'neutral';
    case SLIGHTLY_PLEASANT = 'slightly_pleasant';
    case PLEASANT = 'pleasant';
    case VERY_PLEASANT = 'very_pleasant';

    public function getDetails(): int
    {
        return match ($this) {
            self::VERY_UNPLEASANT => 1,
            self::UNPLEASANT => 2,
            self::SLIGHTLY_UNPLEASANT => 3,
            self::NEUTRAL => 4,
            self::SLIGHTLY_PLEASANT => 5,
            self::PLEASANT => 6,
            self::VERY_PLEASANT => 7,
        };
    }
}
