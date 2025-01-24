<?php
/*
 * @var Collection $persons
 */
?>

<div class="flex h-[calc(100vh-48px)] flex-col overflow-hidden bg-white">
  <!-- Search header - fixed -->
  <div class="shrink-0 border-b border-gray-200 p-3">
    <div class="relative">
      <x-lucide-search class="pointer-events-none absolute top-1/2 left-2 h-4 w-4 -translate-y-1/2 text-gray-500" />
      <x-text-input type="text" placeholder="{{ __('Search contacts...') }}" class="w-full border border-gray-300 bg-gray-100 py-1 pr-3 pl-8 text-sm focus:bg-white" />
    </div>
  </div>

  <div class="shrink-0 border-b border-gray-200 p-3">
    <a wire:navigate href="{{ route('persons.new') }}" class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add person') }}
    </a>
  </div>

  <!-- Scrollable contact list -->
  <div class="overflow-y-auto">
    <div class="divide-y divide-gray-200">
      @foreach ($persons as $person)
        <a wire:navigate href="{{ route('persons.show', $person['slug']) }}" class="flex items-center gap-3 p-3 hover:bg-blue-50">
          <div class="shrink-0">
            <img class="h-8 w-8 rounded-full object-cover p-[0.1875rem] ring-1 shadow-sm ring-slate-900/10" src="https://i.pravatar.cc/32?u={{ $person['id'] }}" alt="" />
          </div>
          <div class="min-w-0">
            <p class="truncate font-medium">{{ $person['name'] }}</p>
            <p class="truncate text-sm text-gray-600">{{ $person['slug'] }}</p>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
