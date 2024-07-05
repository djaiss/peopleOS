<x-app-layout :inVault="true">
  @foreach ($contacts as $contact)
    {{ $contact['name'] }}
  @endforeach
</x-app-layout>
