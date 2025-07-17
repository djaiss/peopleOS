<?php

declare(strict_types=1);

namespace App\Enums;

enum TwoFactorType: string
{
    case NONE = 'none';
    case EMAIL = 'email';
    case AUTHENTICATOR = 'authenticator';
}
