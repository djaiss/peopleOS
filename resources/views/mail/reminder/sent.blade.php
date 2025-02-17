<x-mail::message>
# Reminder for {{ $personName }}

**Name**: {{ $personName }}

**Occasion**: {{ $name }}

**Date**: {{ $date }}

**Age**: {{ $age }}

<x-mail::panel>
Remember, maintaining relationships takes effort, but it's worth it. Take a moment to reach out - a simple message, call, or meeting can make a big difference.
</x-mail::panel>

<x-mail::button :url="$slug">
View {{ $personName }}'s profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
