<?php
/*
 * @var Collection $days
 */
?>

<div id="days-listing" class="days-grid-{{ $days->count() }} mx-auto mb-8 grid auto-cols-[3rem] grid-flow-col gap-1 px-3 py-2 pb-2">
  @foreach ($days as $day)
    <div class="group {{ $day['is_selected'] ? 'border-indigo-400' : 'border-gray-200' }} {{ $day['is_today'] ? 'bg-indigo-50' : '' }} relative aspect-square cursor-pointer rounded-lg border text-center transition-colors hover:bg-indigo-50">
      <a href="{{ $day['url'] }}" class="flex h-full flex-col items-center justify-center">
        <span class="text-sm font-medium text-gray-900">{{ $day['day'] }}</span>
        <div class="{{ $day['has_blocks'] === true ? 'bg-green-500' : 'bg-transparent' }} mt-1 h-1.5 w-1.5 rounded-full"></div>
      </a>
    </div>
  @endforeach
</div>
