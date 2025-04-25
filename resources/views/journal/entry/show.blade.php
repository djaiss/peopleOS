<?php
/*
  * @var \App\Models\JournalEntry $entry
 * @var Collection $days
 * @var Collection $months
 */
?>

<x-app-layout :classes="'bg-gray-50'">
  {{-- Months navigation --}}
  <div class="bg-white">
    <div class="mx-auto grid grid-cols-12 divide-x divide-gray-200">
      @foreach ($months as $month)
        <a href="{{ $month['url'] }}" class="group {{ $month['is_selected'] ? 'border-indigo-200 bg-indigo-50' : '' }} relative cursor-pointer px-2 py-1 text-center transition-colors hover:bg-indigo-50">
          <div class="text-sm font-medium text-gray-900">{{ $month['month_name'] }}</div>
          <div class="mt-1 text-xs text-gray-500">5 entries</div>
          <div class="{{ $month['is_selected'] ? 'scale-x-100' : '' }} absolute bottom-0 left-0 h-0.5 w-full scale-x-0 bg-indigo-600 transition-transform group-hover:scale-x-100"></div>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Days grid --}}
  <div class="days-grid-{{ $days->count() }} mx-auto grid auto-cols-[3rem] grid-flow-col gap-1 px-3 py-2 pb-2 mb-8">
    @foreach ($days as $day)
      <div class="group {{ $day['is_selected'] ? 'border-indigo-400' : 'border-gray-200' }} {{ $day['is_today'] ? 'bg-indigo-50' : '' }} relative aspect-square cursor-pointer rounded-lg border text-center transition-colors hover:bg-indigo-50" x-data="{ hasEntry: {{ $day['day'] % 3 === 0 ? 'true' : 'false' }} }">
        <a href="{{ $day['url'] }}" class="flex h-full flex-col items-center justify-center">
          <span class="text-sm font-medium text-gray-900">{{ $day['day'] }}</span>
          <div class="mt-1 h-1.5 w-1.5 rounded-full" :class="hasEntry ? 'bg-green-500' : 'bg-transparent'"></div>
        </a>
      </div>
    @endforeach
  </div>

  <div class="mx-auto max-w-7xl">

    <div class="grid grid-cols-2 gap-4">
      <!-- left column -->
      <div class="col-span-1">
        <h1 class="text-2xl font-bold">Entry for {{ $entry->getDate() }}</h1>

        <div id="life-events-list" class="ml-3 flex flex-col gap-y-7 border-l border-gray-300">
          <div id="" class="relative flex gap-x-3">
            <!-- icon -->
            <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
              <x-lucide-check class="h-4 w-4 text-white" />
            </div>

            <!-- description -->
            <div class="relative flex flex-col gap-y-3 pl-6">
              <div class="group relative">
                <a x-target="" href="" class="rounded px-1 group-hover:bg-amber-100">Test</a>
                <span class="ml-1 inline-block text-xs text-gray-500">2025-04-23</span>
              </div>
            </div>
          </div>
          <div id="" class="relative flex gap-x-3">
            <!-- icon -->
            <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
              <x-lucide-check class="h-4 w-4 text-white" />
            </div>

            <!-- description -->
            <div class="relative flex flex-col gap-y-3 pl-6">
              <div class="group relative">
                <a x-target="" href="" class="rounded px-1 group-hover:bg-amber-100">Test</a>
                <span class="ml-1 inline-block text-xs text-gray-500">2025-04-23</span>
              </div>
            </div>
          </div>
          <div id="" class="relative flex gap-x-3">
            <!-- icon -->
            <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
              <x-lucide-check class="h-4 w-4 text-white" />
            </div>

            <!-- description -->
            <div class="relative flex flex-col gap-y-3 pl-6">
              <div class="group relative">
                <a x-target="" href="" class="rounded px-1 group-hover:bg-amber-100">Test</a>
                <span class="ml-1 inline-block text-xs text-gray-500">2025-04-23</span>
              </div>
            </div>
          </div>
          <div id="" class="relative flex gap-x-3">
            <!-- icon -->
            <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
              <x-lucide-check class="h-4 w-4 text-white" />
            </div>

            <!-- description -->
            <div class="relative flex flex-col gap-y-3 pl-6">
              <div class="group relative">
                <a x-target="" href="" class="rounded px-1 group-hover:bg-amber-100">Test</a>
                <span class="ml-1 inline-block text-xs text-gray-500">2025-04-23</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- right column -->
      <div class="col-span-1">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <!-- mental health -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-brain class="h-4 w-4 text-blue-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Mental health') }}</h2>
                </div>
              </div>

              <div class="group hover:bg-blue-50 cursor-pointer rounded-t-lg border border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-smile class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log your mood for the day') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-bed-double class="group-hover:text-green-600 h-5 w-5 text-green-500" />
                  <h2 class="text-sm">{{ __('Log your energy level') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 rounded-b-lg cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-rain class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log your stress level') }}</h2>
                </div>
              </div>
            </div>

            <!-- physical well-being -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-dumbbell class="h-4 w-4 text-blue-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Physical well-being') }}</h2>
                </div>
              </div>

              <div class="group hover:bg-blue-50 cursor-pointer rounded-t-lg border border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-smile class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('How did you sleep?') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-bed-double class="group-hover:text-green-600 h-5 w-5 text-green-500" />
                  <h2 class="text-sm">{{ __('Log your physical activity') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-rain class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log what you ate') }}</h2>
                </div>
              </div>
              <div class="group mb-6 hover:bg-blue-50 rounded-b-lg cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-rain class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log your hydration') }}</h2>
                </div>
              </div>
            </div>
          </div>

          <div>
            <!-- environment -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-sun class="h-4 w-4 text-blue-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Environment') }}</h2>
                </div>
              </div>

              <div class="group hover:bg-blue-50 cursor-pointer rounded-lg border border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-smile class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Record the weather') }}</h2>
                </div>
              </div>
            </div>

            <!-- social and interaction -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-handshake class="h-4 w-4 text-blue-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Social and interaction') }}</h2>
                </div>
              </div>

              <div class="group hover:bg-blue-50 cursor-pointer rounded-t-lg border border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-smile class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log your social interactions') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-bed-double class="group-hover:text-green-600 h-5 w-5 text-green-500" />
                  <h2 class="text-sm">{{ __('Meaningful encounters') }}</h2>
                </div>
              </div>
              <div class="group hover:bg-blue-50 rounded-b-lg cursor-pointer border-b border-r border-l border-gray-200 bg-white p-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-rain class="group-hover:text-blue-600 h-5 w-5 text-blue-500" />
                  <h2 class="text-sm">{{ __('Log your degree of solitude') }}</h2>
                </div>
              </div>
            </div>

          </div>
        </div>


        <div x-data="{mood:4}" class="flex items-center justify-center gap-x-3 rounded-lg border border-gray-200 bg-white p-4 text-center transition-all duration-800 ease-in-out">
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
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
