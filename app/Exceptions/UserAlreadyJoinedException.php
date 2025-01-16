<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UserAlreadyJoinedException extends Exception
{
    public function __construct(string $message = 'User already joined the account.')
    {
        parent::__construct($message);
    }
}
