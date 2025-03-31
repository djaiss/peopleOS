<x-app-layout>
  {{-- Months navigation --}}
  <div class="bg-white">
    <div class="mx-auto grid grid-cols-12 divide-x divide-gray-200">
      @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
        <div class="group relative cursor-pointer px-2 py-1 text-center transition-colors hover:bg-indigo-50" x-data="{ count: 5 }" {{-- This will be replaced with actual count --}}>
          <div class="text-sm font-medium text-gray-900">{{ $month }}</div>
          <div class="mt-1 text-xs text-gray-500">
            <span x-text="count"></span>
            entries
          </div>
          <div class="absolute bottom-0 left-0 h-0.5 w-full scale-x-0 bg-indigo-600 transition-transform group-hover:scale-x-100"></div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Days grid --}}
  <div class="mb-4 bg-white px-4 py-3">
    <div class="grid auto-cols-[3rem] grid-flow-col gap-1 overflow-x-auto pb-2 xl:grid-cols-[repeat(31,1fr)] xl:overflow-x-visible">
      @for ($i = 1; $i <= 31; $i++)
        <div
          class="group relative aspect-square cursor-pointer rounded-lg border text-center transition-colors hover:bg-indigo-50"
          :class="{
                        'bg-indigo-50 border-indigo-200': {{ $i }} === (new Date()).getDate(),
                        'border-gray-200': {{ $i }} !== (new Date()).getDate()
                    }"
          x-data="{ hasEntry: {{ $i % 3 === 0 ? 'true' : 'false' }} }">
          <div class="flex h-full flex-col items-center justify-center">
            <span class="text-sm font-medium text-gray-900">{{ $i }}</span>
            <div class="mt-1 h-1.5 w-1.5 rounded-full" :class="hasEntry ? 'bg-green-500' : 'bg-transparent'"></div>
          </div>
        </div>
      @endfor
    </div>
  </div>

  <p>{{ $entry->day }} {{ $entry->month }} {{ $entry->year }}</p>
</x-app-layout>
