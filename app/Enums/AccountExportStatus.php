<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountExportStatus: string
{
    case STARTED = 'started';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
