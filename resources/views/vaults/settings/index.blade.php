<x-app-layout :vault="$vault">
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline">
          <x-link href="{{ route('settings.index') }}">{{ __('Settings') }}</x-link>
        </li>
        <li class="inline">{{ __('Preferences') }}</li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-20">
    <div class="mx-auto max-w-3xl px-2 py-2 sm:px-0 sm:py-6"></div>
  </main>
</x-app-layout>
