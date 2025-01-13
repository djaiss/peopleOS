<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Enable the paid version
    |--------------------------------------------------------------------------
    |
    | This value enables the paid version of the application. If you
    | self host the application, you probably want to disable this since
    | you will not have a way to purchase a lifetime access.
    |
    */

    'enable_paid_version' => env('ENABLE_PAID_VERSION', false),


    /*
    |--------------------------------------------------------------------------
    | Possible actions
    |--------------------------------------------------------------------------
    |
    | These are the possible actions that can be performed.
    |
    */

    'actions' => [
        'account_creation' => 'Account creation',
        'personal_profile_update' => 'Update on the personal profile',
        'display_full_names_toggle' => 'Toggle display of full names',
        'display_age_toggle' => 'Toggle display of age',
        'api_key_creation' => 'API key creation',
        'api_key_deletion' => 'API key deletion',
        'user_invitation' => 'User invitation',
        'user_invitation_resend' => 'User invitation resend',
        'office_creation' => 'Office creation',
        'office_update' => 'Office update',
        'office_deletion' => 'Office destroy',
        'team_creation' => 'Team creation',
        'team_deletion' => 'Team deletion',
        'team_update' => 'Team update',
        'profile_picture_update' => 'Profile picture update',
    ],

];
