<x-mail::message>
# Welcome to {{ config('app.name') }}

Hi,

Great news! You've been accepted from the waitlist and can now access {{ config('app.name') }}.

<x-mail::button :url="route('login')">
Login to your account
</x-mail::button>

We're excited to have you on board.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
