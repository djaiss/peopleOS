<x-mail::message>
  # New API key created

  A personal API key with the label {{ $label }} has been created on {{ config('app.name') }}.

  <x-mail::panel>If you did not authorize this action, please contact support.</x-mail::panel>

  Thanks,<br>
  {{ config('app.name') }}
</x-mail::message>
