<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UserAlreadyExistsException extends Exception
{
    public function __construct(string $message = 'User already exists.')
    {
        parent::__construct($message);
    }
}
