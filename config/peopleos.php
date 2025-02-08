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
        'profile_picture_update' => 'Profile picture update',
        'gender_creation' => 'Gender creation',
        'gender_update' => 'Gender update',
        'gender_deletion' => 'Gender deletion',
        'person_creation' => 'Person creation',
        'person_update' => 'Person update',
        'person_deletion' => 'Person deletion',
        'note_creation' => 'Note creation',
        'note_update' => 'Note update',
        'note_deletion' => 'Note deletion',
        'work_history_creation' => 'Work history creation',
        'work_history_update' => 'Work history update',
        'work_history_deletion' => 'Work history deletion',
        'account_pruning' => 'Account pruning',
        'love_relationship_creation' => 'Love relationship creation',
        'love_relationship_update' => 'Love relationship update',
        'love_relationship_deletion' => 'Love relationship deletion',
        'how_i_met_information_update' => 'How I Met Information update',
    ],

];
