<?php

declare(strict_types=1);

namespace App\Enums;

enum GiftStatus: string
{
    case IDEA = 'idea';
    case GIVEN = 'given';
    case RECEIVED = 'received';
}
