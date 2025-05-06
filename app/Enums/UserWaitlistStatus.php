<?php

declare(strict_types=1);

namespace App\Enums;

enum UserWaitlistStatus: string
{
    case SUBSCRIBED_NOT_CONFIRMED = 'subscribed_not_confirmed';
    case SUBSCRIBED_AND_CONFIRMED = 'subscribed_and_confirmed';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
