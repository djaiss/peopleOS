<form action="{{ route('journal.entry.mood.create', ['year' => $year, 'month' => $month, 'day' => $day]) }}" method="POST" id="new-content" x-data="{mood:4}" class="mx-auto max-w-xl rounded-lg border border-gray-200 bg-white text-center transition-all duration-800 ease-in-out">
  @csrf

  <!-- mood -->
  <div class="flex items-center justify-center gap-x-3 p-4 ">
    <div class="rounded-full border-2 h-20 w-20 transition-all duration-800 ease-in-out" :style="{
        1: 'background: radial-gradient(circle at center, #e9e8f5, #b9afd7); border-color: #b9afd7',
        2: 'background: radial-gradient(circle at center, #eaeefc, #c1caed); border-color: #c1caed',
        3: 'background: radial-gradient(circle at center, #ebf0f8, #c4d2e0); border-color: #c4d2e0',
        4: 'background: radial-gradient(circle at center, #eff4f1, #c4d8c8); border-color: #c4d8c8',
        5: 'background: radial-gradient(circle at center, #eaf1d7, #b9d395); border-color: #b9d395',
        6: 'background: radial-gradient(circle at center, #f3f2db, #d6d49b); border-color: #d6d49b',
        7: 'background: radial-gradient(circle at center, #fcf0db, #f6d19e); border-color: #f6d19e'
    }[mood]"></div>
    <div class="flex flex-col items-center justify-center gap-x-3">
      <p class="text-sm text-gray-500">Today I felt</p>
      <p class="mb-3 font-semibold" x-text="{
            1: 'Very unpleasant',
            2: 'Unpleasant',
            3: 'Slightly unpleasant',
            4: 'Neutral',
            5: 'Slightly pleasant',
            6: 'Pleasant',
            7: 'Very pleasant'
          }[mood]"></p>
      <input class="w-2/3 h-2 appearance-none rounded-xl cursor-move bg-green-500 [::-webkit-slider-runnable-track]:bg-green-500 [::-moz-range-track]:bg-green-500" type="range" x-model="mood" min="1" max="7" step="1">
      <input type="hidden" name="mood" :value="{
            1: 'very_unpleasant',
            2: 'unpleasant',
            3: 'slightly_unpleasant',
            4: 'neutral',
            5: 'slightly_pleasant',
            6: 'pleasant',
            7: 'very_pleasant'
          }[mood]">
    </div>
  </div>

  <!-- actions -->
  <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
    <x-button.secondary x-target="new-content" href="{{ route('journal.entry.show', ['year' => $year, 'month' => $month, 'day' => $day]) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>