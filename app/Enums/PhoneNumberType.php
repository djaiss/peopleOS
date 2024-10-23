<?php

namespace App\Enums;

enum PhoneNumberType: string
{
    case HOME = 'home';
    case WORK = 'work';
    case MOBILE = 'mobile';
    case FAX = 'fax';
    case OTHER = 'other';
}
