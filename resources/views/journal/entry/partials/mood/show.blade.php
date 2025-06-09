<?php
/*
 * @var array $block
 */
?>

<div class="mx-auto max-w-xl rounded-lg border border-gray-200 bg-white text-center transition-all duration-800 ease-in-out">
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

    <div class="flex flex-col items-center justify-center gap-x-3">
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
