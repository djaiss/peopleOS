<?php
/*
 * @var Person $person
 */
?>

<!-- How We Met Section -->
@if ($person->how_we_met || $person->how_we_met_location || $person->how_we_met_first_impressions || $person->howWeMetSpecialDate)
  <section id="edit-how-we-met-form" x-data="{
    expanded: {{ $person->how_we_met_shown ? 'true' : 'false' }},
  }" class="mb-8">
    <div class="mb-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <x-lucide-footprints class="h-5 w-5 text-purple-500" />
        <h2 class="text-lg font-semibold text-gray-900">{{ __('How we met') }}</h2>
      </div>
      <div class="flex items-center gap-2">
        <a x-target="edit-how-we-met-form" href="{{ route('persons.how-we-met.post', $person->slug) }}" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-200">
          <span x-text="expanded ? '{{ __('Show less') }}' : '{{ __('Show more') }}'"></span>
          <x-lucide-chevron-down x-show="!expanded" class="h-4 w-4" />
          <x-lucide-chevron-up x-show="expanded" class="h-4 w-4" />
        </a>
        <a x-target="edit-how-we-met-form" href="{{ route('persons.how-we-met.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-purple-50 px-3 py-2 text-sm font-medium text-purple-600 hover:bg-purple-100">
          <x-lucide-pencil class="mr-1 h-3 w-3" />
          {{ __('Edit') }}
        </a>
      </div>
    </div>

    <!-- Collapsed State -->
    <div x-show="!expanded" x-transition class="rounded-lg border border-gray-200 bg-white">
      <div class="relative flex items-center gap-4 p-4">
        <div class="flex shrink-0 items-center gap-3 text-sm text-gray-500">
          @if ($person->howWeMetSpecialDate)
            <div class="flex items-center gap-1">
              <x-lucide-calendar class="h-4 w-4" />
              <x-tooltip text="{{ $person->howWeMetSpecialDate?->age }}">
                <span>{{ $person->howWeMetSpecialDate?->date }}</span>
              </x-tooltip>
            </div>
          @endif

          <div class="flex items-center gap-1">
            <x-lucide-map-pin class="h-4 w-4" />
            <span>{{ $person->how_we_met_location }}</span>
          </div>
        </div>
        <p class="line-clamp-1 flex-1 text-sm text-gray-600">{{ $person->how_we_met }}</p>

        @if ($person->howWeMetSpecialDate?->should_be_reminded)
          <div class="absolute -top-2 -right-1 rounded-full border border-gray-200 bg-white p-1">
            <x-lucide-bell-ring class="h-4 w-4 text-gray-400" />
          </div>
        @endif
      </div>
    </div>

    <!-- Expanded State -->
    <div x-cloak x-show="expanded" x-transition class="rounded-lg border border-gray-200 bg-white p-4">
      <div class="space-y-4">
        <!-- Meeting Details Grid -->
        <div class="grid grid-cols-2 gap-4">
          <!-- Date -->
          <div class="flex items-center gap-2">
            <x-lucide-calendar class="h-4 w-4 text-gray-400" />
            @if ($person->howWeMetSpecialDate)
              <x-tooltip text="{{ $person->howWeMetSpecialDate?->age }}">
                <span class="text-sm text-gray-600">{{ $person->howWeMetSpecialDate?->date }}</span>
              </x-tooltip>
            @else
              <span class="text-sm text-gray-600">{{ __('Unknown') }}</span>
            @endif
          </div>

          <!-- Location -->
          @if ($person->how_we_met_location)
            <div class="flex items-center gap-2">
              <x-lucide-map-pin class="h-4 w-4 text-gray-400" />
              <span class="text-sm text-gray-600">{{ $person->how_we_met_location }}</span>
            </div>
          @endif

          <!-- Introduced By -->
          <div class="flex items-center gap-2">
            <x-lucide-users class="h-4 w-4 text-gray-400" />
            <span class="text-sm text-gray-600">sdfs</span>
          </div>
        </div>

        <!-- Reminder -->
        @if ($person->howWeMetSpecialDate?->should_be_reminded)
          <div class="border-t pt-4">
            <h3 class="mb-2 text-sm font-medium text-gray-900">{{ __('Reminder') }}</h3>
            <p class="text-sm text-gray-600">{{ __('A reminder will be sent to you on :date.', ['date' => $person->howWeMetSpecialDate?->date]) }}</p>
          </div>
        @endif

        <!-- First Impressions -->
        @if ($person->how_we_met_first_impressions)
          <div class="border-t pt-4">
            <h3 class="mb-2 text-sm font-medium text-gray-900">{{ __('First Impressions') }}</h3>
            <p class="text-sm text-gray-600">{{ $person->how_we_met_first_impressions }}</p>
          </div>
        @endif

        <!-- Story -->
        @if ($person->how_we_met)
          <div class="border-t pt-4">
            <h3 class="mb-2 text-sm font-medium text-gray-900">{{ __('The Story') }}</h3>
            <p class="text-sm whitespace-pre-wrap text-gray-600">{{ $person->how_we_met }}</p>
          </div>
        @endif
      </div>
    </div>
  </section>
@else
  <section class="mb-8">
    <div class="mb-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <x-lucide-footprints class="h-5 w-5 text-purple-500" />
        <h2 class="text-lg font-semibold text-gray-900">{{ __('How we met') }}</h2>
      </div>
    </div>

    <div id="edit-how-we-met-form" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center">
      <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
        <x-lucide-footprints class="h-6 w-6 text-purple-600" />
      </div>
      <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No meeting story yet') }}</h3>
      <p class="mt-1 text-sm text-gray-500">
        {{ __('Record how you first met this person to keep this memory forever.') }}
      </p>
      <div class="mt-6">
        <a x-target="edit-how-we-met-form" href="{{ route('persons.how-we-met.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-purple-50 px-3 py-2 text-sm font-medium text-purple-600 hover:bg-purple-100">
          <x-lucide-plus class="h-4 w-4" />
          {{ __('Add your story') }}
        </a>
      </div>
    </div>
  </section>
@endif
