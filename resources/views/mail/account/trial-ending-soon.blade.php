<x-mail::message>
# Your PeopleOS trial is ending soon

It's been almost 30 days since you signed up for PeopleOS. We really hope you're enjoying it!

In 5 days, your trial will end.

However, in order to keep using PeopleOS, you need to upgrade your account.

The good news: PeopleOS is not a subscription-based service - it's a one-time payment.

<x-mail::button :url="$link">
Upgrade your account now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
