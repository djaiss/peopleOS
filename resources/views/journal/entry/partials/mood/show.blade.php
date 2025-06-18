<?php
/*
 * @var array $block
 * @var Entry $entry
 */
?>

<div class="group">
  <div class="invisible mx-auto mb-1 flex max-w-xl items-center justify-between text-sm opacity-0 transition-opacity duration-200 group-hover:visible group-hover:opacity-100">
    <p>{{ __('Mood') }}</p>
    <div class="flex gap-x-3">
      <a x-target="edit-mood-{{ $block['data']['id'] }}" href="{{ route('journal.entry.mood.edit', ['year' => $entry->year, 'month' => $entry->month, 'day' => $entry->day, 'mood' => $block['data']['id']]) }}" class="text-gray-500 hover:text-gray-700">Edit</a>
      <a href="" class="text-gray-500 hover:text-gray-700">Delete</a>
    </div>
  </div>
  <div id="edit-mood-{{ $block['data']['id'] }}" class="mx-auto max-w-xl rounded-lg border border-gray-200 bg-white transition-all duration-800 ease-in-out">
    <div class="flex items-center gap-x-3 p-4">
      <div
        class="h-20 w-20 rounded-full border-2 transition-all duration-800 ease-in-out"
        :style="{
          1: 'background: radial-gradient(circle at center, #e9e8f5, #b9afd7); border-color: #b9afd7',
          2: 'background: radial-gradient(circle at center, #eaeefc, #c1caed); border-color: #c1caed',
          3: 'background: radial-gradient(circle at center, #ebf0f8, #c4d2e0); border-color: #c4d2e0',
          4: 'background: radial-gradient(circle at center, #eff4f1, #c4d8c8); border-color: #c4d8c8',
          5: 'background: radial-gradient(circle at center, #eaf1d7, #b9d395); border-color: #b9d395',
          6: 'background: radial-gradient(circle at center, #f3f2db, #d6d49b); border-color: #d6d49b',
          7: 'background: radial-gradient(circle at center, #fcf0db, #f6d19e); border-color: #f6d19e'
      }[{{ $block['data']['mood'] }}]"></div>

      <div>
        <p class="text-sm text-gray-500">{{ __('Today I felt') }}</p>
        <p class="font-semibold" x-text="{
              1: 'Very unpleasant',
              2: 'Unpleasant',
              3: 'Slightly unpleasant',
              4: 'Neutral',
              5: 'Slightly pleasant',
              6: 'Pleasant',
              7: 'Very pleasant'
            }[{{ $block['data']['mood'] }}]"></p>
      </div>
    </div>
  </div>
</div>
