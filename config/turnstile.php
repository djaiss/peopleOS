<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Turnstile keys
     |--------------------------------------------------------------------------
     |
     | To start using the Turnstile widget, you will need to obtain a sitekey
     | and a secret key. The sitekey and secret key are always associated
     | with one widget and cannot be reused for other widgets.
     |
     | https://developers.cloudflare.com/turnstile/get-started/
     |
     */
    'sitekey'   => env(key: 'TURNSTILE_SITE_KEY'),
    'secretkey' => env(key: 'TURNSTILE_SECRET_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Status
     |--------------------------------------------------------------------------
     |
     | This option allows you to enable or disable turnstile. This is useful
     | when testing your application. Disabling ensure your tests runs
     | smoothly. remember to enable once you are done testing.
     |
     */
    'enabled' => env(key: 'TURNSTILE_ENABLED', default: true),

    /*
     |--------------------------------------------------------------------------
     | Field name
     |--------------------------------------------------------------------------
     |
     | This is the name of the turnstile validation field from your front-end
     | application. Failure to include the field in the request will cause
     | a runtime exception. This is precautionary measure.
     |
     */
    'field' => env(key: 'TURNSTILE_FIELD', default: 'cf-turnstile-response'),

    /*
     |--------------------------------------------------------------------------
     | Turnstile Site Verify Url
     |--------------------------------------------------------------------------
     |
     | This is the cloudflare endpoint that is used to verify the turnstile
     | token. You must must call the siteverify endpoint to validate the
     | Turnstile widget response
     |
     | Learn more: https://developers.cloudflare.com/turnstile/get-started/server-side-validation/
     |
     */
    'url' => env(key: 'TURNSTILE_URL', default: 'https://challenges.cloudflare.com/turnstile/v0/siteverify'),
];
