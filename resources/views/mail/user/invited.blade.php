<x-mail::message>
# You are invited to join the account

You have been invited to join the account {{ config('app.name') }}.

<x-mail::button :url="$temporarySignedRoute">
Join the account
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
