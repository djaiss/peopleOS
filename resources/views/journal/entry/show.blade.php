<?php
/*
 * @var array $options
 * @var \App\Models\Entry $entry
 * @var Collection $days
 * @var Collection $months
 * @var Collection $blocks
 */
?>

<x-app-layout :classes="'bg-gray-50'">
  {{-- Months navigation --}}
  @include('journal.entry.partials.months', ['months' => $months])

  {{-- Days grid --}}
  @include('journal.entry.partials.days', ['days' => $days])

  <div class="mx-auto max-w-7xl">
    <div class="mb-10" x-data="{ open: false }">
      <!-- title -->
      <h1 class="mb-4 text-center font-serif text-2xl font-normal">{{ $entry->getDate() }}</h1>

      <!-- add content button -->
      <div class="mb-8 flex items-center justify-center">
        <button @click="open = !open" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 transition-colors duration-200 hover:bg-indigo-200" :class="{ 'rotate-45': open }">
          <x-lucide-plus class="h-5 w-5 text-indigo-600 transition-transform duration-200" />
        </button>
      </div>

      <!-- add action modal -->
      <div x-cloak x-show="open" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="scale-95 transform opacity-0" x-transition:enter-end="scale-100 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="scale-100 transform opacity-100" x-transition:leave-end="scale-95 transform opacity-0" class="mt-6">
        <div class="mx-auto grid max-w-3xl grid-cols-2 gap-4">
          <!-- left column -->
          <div>
            <!-- mental health -->
            <div class="mb-6">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-brain class="h-4 w-4 text-indigo-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Mental health') }}</h2>
                </div>
              </div>

              <div class="group flex cursor-pointer items-center justify-between rounded-t-lg border border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-pen-tool class="h-5 w-5 text-indigo-500 group-hover:text-indigo-600" />
                  <h2 class="text-sm">{{ __('Add your journal thoughts') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <a x-target="new-content" @click="open = false" href="{{ route('journal.entry.mood.new', ['year' => $entry->year, 'month' => $entry->month, 'day' => $entry->day]) }}" class="flex items-center gap-2">
                  <x-lucide-smile class="h-5 w-5 text-yellow-500 group-hover:text-yellow-600" />
                  <h2 class="text-sm">{{ __('Log your mood for the day') }}</h2>
                </a>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-battery class="h-5 w-5 text-emerald-500 group-hover:text-emerald-600" />
                  <h2 class="text-sm">{{ __('Log your energy level') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-waves class="h-5 w-5 text-cyan-500 group-hover:text-cyan-600" />
                  <h2 class="text-sm">{{ __('Log your stress level') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-heart class="h-5 w-5 text-rose-500 group-hover:text-rose-600" />
                  <h2 class="text-sm">{{ __('Log what you\'re grateful for') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between rounded-b-lg border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-lightbulb class="h-5 w-5 text-amber-500 group-hover:text-amber-600" />
                  <h2 class="text-sm">{{ __('Log your learnings') }}</h2>
                </div>
              </div>
            </div>

            <!-- physical well-being -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-dumbbell class="h-4 w-4 text-violet-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Physical well-being') }}</h2>
                </div>
              </div>

              <div class="group flex cursor-pointer items-center justify-between rounded-t-lg border border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-moon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-600" />
                  <h2 class="text-sm">{{ __('How did you sleep?') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-bike class="h-5 w-5 text-violet-500 group-hover:text-violet-600" />
                  <h2 class="text-sm">{{ __('Log your physical activity') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-utensils class="h-5 w-5 text-orange-500 group-hover:text-orange-600" />
                  <h2 class="text-sm">{{ __('Log what you ate') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-droplet class="h-5 w-5 text-sky-500 group-hover:text-sky-600" />
                  <h2 class="text-sm">{{ __('Log your hydration') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between rounded-b-lg border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-pill class="h-5 w-5 text-purple-500 group-hover:text-purple-600" />
                  <h2 class="text-sm">{{ __('Log medication/supplement intake') }}</h2>
                </div>
              </div>
            </div>
          </div>

          <!-- right column -->
          <div>
            <!-- environment -->
            <div class="mb-6">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud-sun class="h-4 w-4 text-sky-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Environment') }}</h2>
                </div>
              </div>

              <div class="group flex cursor-pointer items-center justify-between rounded-t-lg border border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-cloud class="h-5 w-5 text-sky-500 group-hover:text-sky-600" />
                  <h2 class="text-sm">{{ __('Record the weather') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-map-pin class="h-5 w-5 text-emerald-500 group-hover:text-emerald-600" />
                  <h2 class="text-sm">{{ __('Log current location') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between rounded-b-lg border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-volume-2 class="h-5 w-5 text-cyan-500 group-hover:text-cyan-600" />
                  <h2 class="text-sm">{{ __('Log air quality/noise level') }}</h2>
                </div>
              </div>
            </div>

            <!-- social and interaction -->
            <div class="mb-6">
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-users class="h-4 w-4 text-rose-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Social and interaction') }}</h2>
                </div>
              </div>

              <div class="group flex cursor-pointer items-center justify-between rounded-t-lg border border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-message-circle class="h-5 w-5 text-rose-500 group-hover:text-rose-600" />
                  <h2 class="text-sm">{{ __('Log your social interactions') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-star class="h-5 w-5 text-amber-500 group-hover:text-amber-600" />
                  <h2 class="text-sm">{{ __('Meaningful encounters') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between rounded-b-lg border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-user class="h-5 w-5 text-indigo-500 group-hover:text-indigo-600" />
                  <h2 class="text-sm">{{ __('Log your degree of solitude') }}</h2>
                </div>
              </div>
            </div>

            <!-- creativity and leisure -->
            <div>
              <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <x-lucide-palette class="h-4 w-4 text-fuchsia-500" />
                  <h2 class="text-md font-semibold text-gray-900">{{ __('Creativity and leisure') }}</h2>
                </div>
              </div>

              <div class="group flex cursor-pointer items-center justify-between rounded-t-lg border border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-paintbrush class="h-5 w-5 text-fuchsia-500 group-hover:text-fuchsia-600" />
                  <h2 class="text-sm">{{ __('Log creative activities') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-gamepad class="h-5 w-5 text-violet-500 group-hover:text-violet-600" />
                  <h2 class="text-sm">{{ __('Log hobbies/leisure time') }}</h2>
                </div>
              </div>
              <div class="group flex cursor-pointer items-center justify-between rounded-b-lg border-r border-b border-l border-gray-200 bg-white p-4 hover:bg-blue-50">
                <div class="flex items-center gap-2">
                  <x-lucide-book-open class="h-5 w-5 text-amber-500 group-hover:text-amber-600" />
                  <h2 class="text-sm">{{ __('Track media consumption (books, movies, music)') }}</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- new block modal -->
      <div id="new-content" x-show="!open" x-transition></div>

      <!-- blocks -->
      @foreach ($blocks as $block)
        @include('journal.entry.partials.' . $block['type'] . '.show', ['block' => $block])
      @endforeach
    </div>
  </div>
</x-app-layout>
