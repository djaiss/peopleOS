<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class PermissionException extends Exception
{
    public function __construct(string $message = 'You are not authorized to perform this action.')
    {
        parent::__construct($message);
    }
}
