<x-mail::message>
# Confirm your email address

Please confirm your participation to the PeopleOS waitlist by clicking the link below.

The link will expire in 30 minutes.

<x-mail::button :url="$link">
Confirm email address
</x-mail::button>

{{ config('app.name') }}
</x-mail::message>
