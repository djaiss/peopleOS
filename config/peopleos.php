<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Show the marketing site
    |--------------------------------------------------------------------------
    |
    | This value enables the marketing site to be shown. If you
    | self host the application, you probably want to disable this since
    | you don't need to show the marketing site.
    |
    */

    'show_marketing_site' => env('SHOW_MARKETING_SITE', false),

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
    | Enable anti spam
    |--------------------------------------------------------------------------
    |
    | This value enables the spam verification with Cloudflare turnstile.
    |
    */

    'enable_anti_spam' => env('ENABLE_ANTI_SPAM', false),

    /*
    |--------------------------------------------------------------------------
    | Supported locales
    |--------------------------------------------------------------------------
    |
    | This value enables the supported locales of the application.
    |
    */

    'supported_locales' => ['en', 'fr'],

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
        'encounter_creation' => 'Encounter creation',
        'encounter_deletion' => 'Encounter deletion',
        'person_avatar_update' => 'Person avatar update',
        'timezone_update' => 'Timezone update',
        'person_information_update' => 'Person information update',
        'gift_creation' => 'Gift creation',
        'gift_update' => 'Gift update',
        'gift_deletion' => 'Gift deletion',
        'task_category_creation' => 'Task category creation',
        'task_category_update' => 'Task category update',
        'task_category_deletion' => 'Task category deletion',
        'task_creation' => 'Task creation',
        'task_update' => 'Task update',
        'task_toggle' => 'Task toggle',
        'task_deletion' => 'Task deletion',
        'journal_template_creation' => 'Journal template creation',
        'journal_template_update' => 'Journal template update',
        'journal_template_deletion' => 'Journal template deletion',
        'journal_creation' => 'Journal creation',
        'journal_update' => 'Journal update',
        'journal_deletion' => 'Journal deletion',
        'entry_creation' => 'Entry creation',
        'entry_update' => 'Entry update',
        'entry_deletion' => 'Entry deletion',
        'age_update' => 'Age update',
        'person_physical_appearance_update' => 'Person physical appearance update',
        'stop_sending_reminder' => 'Stop sending reminder',
        'life_event_creation' => 'Life event creation',
        'life_event_update' => 'Life event update',
        'life_event_deletion' => 'Life event deletion',
    ],
];
