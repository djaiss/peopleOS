<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UserNotPartOfTheTeamException extends Exception
{
    public function __construct(string $message = 'You are not part of the team.')
    {
        parent::__construct($message);
    }
}
