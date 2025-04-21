<?php
/*
  * @var \App\Models\JournalEntry $entry
 * @var Collection $days
 * @var Collection $months
 */
?>

<x-app-layout>
  {{-- Months navigation --}}
  <div class="bg-white">
    <div class="mx-auto grid grid-cols-12 divide-x divide-gray-200">
      @foreach ($months as $month)
        <a href="{{ $month['url'] }}" class="group relative cursor-pointer px-2 py-1 text-center transition-colors hover:bg-indigo-50 {{ $month['is_selected'] ? 'bg-indigo-50 border-indigo-200' : '' }}">
          <div class="text-sm font-medium text-gray-900">{{ $month['month_name'] }}</div>
          <div class="mt-1 text-xs text-gray-500">
            5
            entries
          </div>
          <div class="absolute bottom-0 left-0 h-0.5 w-full scale-x-0 bg-indigo-600 transition-transform group-hover:scale-x-100 {{ $month['is_selected'] ? 'scale-x-100' : '' }}"></div>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Days grid --}}
  <div class="px-3 py-2 mx-auto grid auto-cols-[3rem] grid-flow-col gap-1 pb-2 days-grid-{{ $days->count() }} ">
    @foreach ($days as $day)
      <div
        class="group relative aspect-square cursor-pointer rounded-lg border text-center transition-colors hover:bg-indigo-50 {{ $day['is_selected'] ? 'border-indigo-400' : 'border-gray-200' }} {{ $day['is_today'] ? 'bg-indigo-50' : '' }}"
        x-data="{ hasEntry: {{ $day['day'] % 3 === 0 ? 'true' : 'false' }} }">
        <a href="{{ $day['url'] }}" class="flex h-full flex-col items-center justify-center">
          <span class="text-sm font-medium text-gray-900">{{ $day['day'] }}</span>
          <div class="mt-1 h-1.5 w-1.5 rounded-full" :class="hasEntry ? 'bg-green-500' : 'bg-transparent'"></div>
        </a>
      </div>
    @endforeach
  </div>

  <p>{{ $entry->day }} {{ $entry->month }} {{ $entry->year }}</p>
</x-app-layout>
