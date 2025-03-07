<?php
/*
 * @var Person $person
 * @var Collection $persons
 */
?>

<div class="flex h-[calc(100vh-48px)] flex-col overflow-hidden bg-white">
  <!-- Search header - fixed -->
  <form x-target="persons" action="{{ route('persons.search') }}" method="POST" class="shrink-0 border-b border-gray-200 p-3">
    @csrf
    @method('POST')

    <div class="relative">
      <x-lucide-search class="pointer-events-none absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-gray-500" />
      <x-text-input @input.debounce="$el.form.requestSubmit()" name="term" type="text" placeholder="{{ __('Search someone') }}" class="w-full border border-gray-300 bg-gray-100 py-1 pr-3 pl-8 text-sm focus:bg-white" autocomplete="off" />
      <x-input-error :messages="$errors->get('term')" class="mt-2" />
    </div>
  </form>

  <div class="shrink-0 border-b border-gray-200 p-3">
    <a href="{{ route('persons.new') }}" class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add person') }}
    </a>
  </div>

  <!-- scrollable contact list -->
  <div class="overflow-y-auto">
    <div id="persons" class="divide-y divide-gray-200">
      @foreach ($persons as $currentPerson)
        <a href="{{ route('persons.show', $currentPerson['slug']) }}" class="{{ isset($person) && $person && $currentPerson['id'] === $person->id ? 'bg-blue-50' : '' }} flex cursor-pointer items-center gap-3 p-3 hover:bg-blue-50">
          <div class="shrink-0">
            <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $currentPerson['avatar'] }}" alt="{{ $currentPerson['name'] }}" />
          </div>
          <div class="min-w-0">
            <p class="truncate font-medium">{{ $currentPerson['name'] }}</p>
            <p class="truncate text-sm text-gray-600">{{ $currentPerson['slug'] }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
