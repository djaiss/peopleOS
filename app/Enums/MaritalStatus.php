<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case CIVIL_UNION = 'civil union';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case COHABITING = 'cohabiting';
    case ENGAGED = 'engaged';
    case IN_A_RELATIONSHIP = 'in a relationship';
    case IT_S_COMPLICATED = 'complicated';
}
