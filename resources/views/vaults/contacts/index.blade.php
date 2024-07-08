<x-app-layout :vault="$vault">
  @foreach ($contacts as $contact)
    {{ $contact['name'] }}
  @endforeach
</x-app-layout>
