<?php
/*
 * @var Person $person
 */
?>

<section id="information" class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-user class="h-5 w-5 text-blue-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Information') }}</h2>
    </div>

    <div class="flex items-center gap-2">
      <a x-target="information-details" href="{{ route('person.information.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
        <x-lucide-pencil class="mr-1 h-3 w-3" />
        {{ __('Edit') }}
      </a>
    </div>
  </div>

  <div id="information-details" class="rounded-lg border border-gray-200 bg-white">
    <div class="grid grid-cols-3 gap-0">
      <div class="flex flex-col border-r border-gray-200 px-4 py-2">
        <span class="text-xs text-gray-500">{{ __('Local time') }}</span>

        @if ($person->timezone)
          <span class="font-medium">{{ $person->currentTime }}</span>
        @else
          <span class="font-medium">{{ __('Not set') }}</span>
        @endif
      </div>

      <div class="flex flex-col border-r border-gray-200 px-4 py-2">
        <span class="text-xs text-gray-500">{{ __('Nationalities') }}</span>

        @if ($person->nationalities)
          <span class="font-medium">{{ $person->nationalities }}</span>
        @else
          <span class="font-medium">{{ __('Not set') }}</span>
        @endif
      </div>

      <div class="flex flex-col px-4 py-2">
        <span class="text-xs text-gray-500">{{ __('Languages') }}</span>

        @if ($person->languages)
          <span class="font-medium">{{ $person->languages }}</span>
        @else
          <span class="font-medium">{{ __('Not set') }}</span>
        @endif
      </div>
    </div>
  </div>
</section>
