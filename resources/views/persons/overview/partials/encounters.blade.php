<?php
/*
 * @var Person $person
 */
?>

<section id="encounters-section" class="mb-8" x-data="{
  encountersExpanded: {{ $person->encounters_shown ? 'true' : 'false' }},
}">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-eye class="h-5 w-5 text-amber-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Encounters') }}</h2>
    </div>
    <div class="flex items-center gap-2">
      <a x-target="encounters-section" href="{{ route('persons.encounters.toggle', $person->slug) }}" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-200">
        <span x-text="encountersExpanded ? '{{ __('Show less') }}' : '{{ __('Show more') }}'"></span>
        <x-lucide-chevron-down x-show="!encountersExpanded" class="h-4 w-4" />
        <x-lucide-chevron-up x-show="encountersExpanded" class="h-4 w-4" />
      </a>
    </div>
  </div>

  <!-- summary + actions -->
  <div class="flex gap-4 rounded-lg border border-gray-200 bg-white">
    <div class="flex flex-col gap-4 border-r border-gray-200 p-4">
      <p class="text-sm text-gray-600">{{ __('Times seen') }}</p>
      <div class="flex items-baseline gap-2">
        <p class="text-2xl font-semibold">{{ $encounters['currentYearCount'] }}</p>
        <p class="text-sm text-gray-500">{{ __('in :year', ['year' => date('Y')]) }}</p>
        @if ($encounters['previousYearCount'] > 0)
          <span class="text-gray-400">·</span>
          <p class="text-sm text-gray-500">{{ $encounters['previousYearCount'] }} {{ __('in :year', ['year' => date('Y') - 1]) }}</p>
        @endif
      </div>
    </div>
    <div class="p-4">
      <p class="mb-3 text-sm text-gray-600">{{ __('Have you seen :name lately?', ['name' => $person->first_name]) }}</p>

      <div class="flex flex-wrap gap-2">
        <form x-target="encounters-section" action="{{ route('persons.encounters.create', $person->slug) }}" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now() }}" />
          <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
            {{ __('Today') }}
          </button>
        </form>

        <form x-target="encounters-section" action="{{ route('persons.encounters.create', $person->slug) }}" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now()->subDay() }}" />
          <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
            {{ __('Yesterday') }}
          </button>
        </form>

        <form x-target="encounters-section" action="{{ route('persons.encounters.create', $person->slug) }}" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now()->subDays(2) }}" />
          <button type="submit" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
            {{ __('2 days ago') }}
          </button>
        </form>

        <a href="{{ route('persons.encounters.new', $person->slug) }}" x-target="add-encounter" type="button" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
          <x-lucide-calendar-plus class="h-4 w-4" />
          {{ __('Custom date') }}
        </a>
      </div>
    </div>
  </div>

  <div id="add-encounter"></div>

  <!-- Recent encounters -->
  <div x-cloak x-show="encountersExpanded" id="encounters-list" class="mt-4 rounded-lg border border-gray-200 bg-white">
    <h3 class="border-b border-gray-200 px-4 py-3 text-sm font-medium text-gray-700">{{ __('Recent encounters') }}</h3>
    <div class="divide-y divide-gray-200">
      @forelse ($encounters['latestSeen'] as $encounter)
        <div id="encounter-{{ $encounter['id'] }}" class="group flex items-center justify-between p-4">
          <div class="flex items-center gap-3">
            <div class="rounded-full bg-indigo-50 p-2">
              <x-lucide-eye class="h-4 w-4 text-indigo-600" />
            </div>
            <div>
              @if ($encounter->context)
                <p class="text-sm font-medium text-gray-900">{{ $encounter->context }}</p>
              @else
                <a x-target="encounter-{{ $encounter['id'] }}" href="{{ route('persons.encounters.edit', [$person->slug, $encounter['id']]) }}" class="border-b border-dashed border-gray-600 text-sm font-medium text-gray-600">{{ __('Add context') }}</a>
              @endif

              <p class="text-sm text-gray-500">{{ $encounter->seen_at->diffForHumans() }}</p>
            </div>
          </div>

          <!-- actions -->
          <div class="flex gap-2">
            <x-button.invisible x-target="encounter-{{ $encounter['id'] }}" href="{{ route('persons.encounters.edit', [$person->slug, $encounter['id']]) }}" class="hidden text-sm group-hover:block">
              {{ __('Edit') }}
            </x-button.invisible>

            <form x-target="encounter-{{ $encounter['id'] }}" x-on:ajax:before="
              confirm('Are you sure you want to proceed? This can not be undone.') ||
                $event.preventDefault()
            " action="{{ route('persons.encounters.destroy', [$person->slug, $encounter['id']]) }}" method="POST">
              @csrf
              @method('DELETE')

              <x-button.invisible class="hidden text-sm group-hover:block">
                {{ __('Delete') }}
              </x-button.invisible>
            </form>
          </div>
        </div>
      @empty
        <div class="flex flex-col items-center justify-center px-4 py-8 text-center">
          <div class="mb-3 rounded-full bg-gray-100 p-3">
            <x-lucide-calendar-x class="h-6 w-6 text-gray-400" />
          </div>
          <p class="mb-1 text-sm font-medium text-gray-900">{{ __('No encounters recorded yet') }}</p>
          <p class="max-w-sm text-sm text-gray-500">
            {{ __('Record when you see :name using the options above to keep track of your encounters.', ['name' => $person->first_name]) }}
          </p>
        </div>
      @endforelse
    </div>
  </div>
</section>
