<?php
/*
 * @var Person $person
 * @var Collection $searchResults
 */
?>

<div id="new-love-relationship" class="mb-8 rounded-lg border border-gray-200 bg-white">
  <!-- Tabs -->
  <div class="mb-4 border-b border-gray-200">
    <nav class="-mb-px flex justify-center space-x-8">
      <a x-target="new-love-relationship" href="{{ route('person.love.new', $person) }}" class="border-b-2 border-transparent px-1 py-3 text-sm font-medium whitespace-nowrap hover:border-gray-300 hover:text-gray-700">
        {{ __('Add someone new') }}
      </a>
      <div class="border-b-2 border-rose-500 px-1 py-3 text-sm font-medium whitespace-nowrap text-rose-600 hover:border-gray-300 hover:text-gray-700">
        {{ __('Add existing person') }}
      </div>
    </nav>
  </div>

  <!-- Create new contact form -->
  <div>
    <!-- search results -->
    <div class="mb-4 space-y-4 px-4">
      <form x-data="{
        searchQuery: '{{ $searchQuery }}',
        debounceTimer: null,
        performSearch() {
          clearTimeout(this.debounceTimer)
          this.debounceTimer = setTimeout(() => {
            this.$el.form.requestSubmit()
          }, 300)
        },
      }" x-target="search-results" x-target.back="new-love-relationship" action="{{ route('person.love.search', $person) }}" method="POST" class="relative">
        @csrf
        @method('POST')

        <x-lucide-search class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-gray-400" />
        <x-text-input id="search" name="search" type="text" x-model="searchQuery" x-on:input="performSearch()" class="block w-full pl-10" placeholder="Search for a contact..." autofocus />
      </form>

      @if ($searchResults && $searchResults->isNotEmpty())
        <div id="search-results" class="divide-y divide-gray-200 rounded-md border border-gray-200">
          @foreach ($searchResults as $result)
            <button type="button" class="flex w-full justify-between p-3 text-left hover:bg-gray-50">
              <div class="flex w-full items-center gap-3">
                <div class="shrink-0">
                  <img class="h-10 w-10 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $result['avatar']['40'] }}" srcset="{{ $result['avatar']['40'] }}, {{ $result['avatar']['80'] }} 2x" alt="{{ $result['name'] }}" loading="lazy" />
                </div>
                <div class="font-medium text-gray-900">{{ $result['name'] }}</div>
              </div>
              <div class="inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-white px-3 py-1 text-center font-semibold text-gray-700 transition duration-150 ease-in-out hover:bg-gray-50 hover:shadow-xs focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden disabled:opacity-25">
                {{ __('Choose') }}
              </div>
            </button>
          @endforeach
        </div>
      @else
        <div id="search-results"></div>
      @endif
    </div>
  </div>

  <form x-target="love-listing new-love-relationship persons" x-target.back="new-love-relationship" action="{{ route('person.love.store', $person) }}" method="POST">
    @csrf

    <div class="mb-4 flex gap-4 px-4"></div>

    <div class="mb-4 flex gap-4 px-4">
      <div class="flex-1">
        <x-input-label for="nature_of_relationship" :value="__('Nature of relationship')" class="mb-1" />
        <x-text-input class="block w-full" id="nature_of_relationship" name="nature_of_relationship" placeholder="{{ __('Ex: Spouse, girlfriend, boyfriend, etc.') }}" type="text" required />
        <x-input-error :messages="$errors->get('nature_of_relationship')" class="mt-2" />
      </div>
    </div>

    <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input id="active" name="active" type="checkbox" value="active" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          <x-input-error :messages="$errors->get('active')" class="mt-2" />
        </div>
      </div>
      <div class="text-sm/6">
        <label for="active" class="font-medium text-gray-900">{{ __('This love relationship is ongoing') }}</label>
        <p id="active-description" class="text-gray-500">{{ __('Select this if the relationship is current. Past relationships will be shown separately.') }}</p>
      </div>
    </div>

    <div class="flex items-center justify-between px-4 pb-4">
      <x-button.secondary x-target="new-love-relationship" href="{{ route('person.family.index', $person) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Create relationship') }}
      </x-button.primary>
    </div>
  </form>
</div>
