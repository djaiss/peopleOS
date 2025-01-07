<?php

declare(strict_types=1);

namespace App\Enums;

enum Permission: string
{
    case ADMINISTRATOR = 'administrator';
    case HR = 'human resource representative';
    case MEMBER = 'member';
}