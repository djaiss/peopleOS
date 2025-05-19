<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="bg-gray-50 py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Left column -->
        <div>
          <!-- reminders -->
          <div class="rounded-lg border border-gray-200 bg-white">
            <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2">
              <div class="flex items-center gap-2">
                <x-lucide-calendar class="h-5 w-5 text-blue-500" />
                <h3 class="text-sm font-medium text-gray-700">{{ __('Reminders in the next 30 days') }}</h3>
              </div>
            </div>
            <div class="divide-y divide-gray-200">
              @forelse ($viewData['reminders'] as $reminder)
                <div class="p-4">
                  <div class="flex items-center gap-x-5">
                    <div class="flex flex-col text-center">
                      <p class="text-xs text-gray-500">{{ $reminder['month'] }}</p>
                      <p class="text-2xl text-gray-500">{{ $reminder['day'] }}</p>
                    </div>

                    <div class="min-w-0 flex-1 gap-y-1">
                      <p class="text-gray-500">{{ $reminder['name'] }}</p>
                      <a href="{{ route('person.show', $reminder['person']['slug']) }}" class="text-xs font-medium text-gray-900 hover:underline">{{ $reminder['person']['name'] }}</a>
                    </div>
                    <img class="h-10 w-10 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $reminder['person']['avatar']['40'] }}" srcset="{{ $reminder['person']['avatar']['40'] }}, {{ $reminder['person']['avatar']['80'] }} 2x" alt="{{ $reminder['person']['name'] }}" loading="lazy" />
                  </div>
                </div>
              @empty
                <div class="flex flex-col items-center justify-center rounded-lg bg-white p-6 text-center">
                  <span class="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                    <x-lucide-calendar-days class="h-6 w-6 text-blue-600" />
                  </span>
                  <p class="text-gray-900">{{ __('No reminders in the next 30 days') }}</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Middle column -->
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 bg-gray-50 px-4 py-2">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <x-lucide-list-todo class="h-5 w-5 text-amber-500" />
                <h3 class="text-sm font-medium text-gray-700">{{ __('Tasks') }}</h3>
              </div>
              <a href="#" class="inline-flex items-center gap-1 rounded-md bg-amber-200 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-300">
                <x-lucide-plus class="mr-1 h-3 w-3" />
                {{ __('Add') }}
              </a>
            </div>
          </div>
          <div class="divide-y divide-gray-200">
            <!-- Sample tasks -->
            <div class="flex justify-between rounded-lg border border-transparent px-4 py-2 hover:border-gray-200 hover:bg-white">
              <div class="flex gap-2">
                <div class="flex h-6 shrink-0 items-center">
                  <input type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
                </div>
                <div class="flex items-center gap-2 text-sm/6">
                  <span class="rounded-md bg-blue-100 px-2 text-gray-500">Work</span>
                  <span class="font-medium text-gray-900">Schedule meeting with John</span>
                  <p class="text-gray-500">Due May 20</p>
                </div>
              </div>
            </div>
            <div class="flex justify-between rounded-lg border border-transparent px-4 py-2 hover:border-gray-200 hover:bg-white">
              <div class="flex gap-2">
                <div class="flex h-6 shrink-0 items-center">
                  <input type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
                </div>
                <div class="flex items-center gap-2 text-sm/6">
                  <span class="rounded-md bg-green-100 px-2 text-gray-500">Personal</span>
                  <span class="font-medium text-gray-900">Buy gift for Jane</span>
                  <p class="text-gray-500">Due June 1</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right column -->
        <div class="space-y-6">
          <!-- Welcome box -->
          <div class="rounded-lg border border-gray-200 bg-white p-4">
            <div class="flex items-center gap-3">
              <img class="h-12 w-12 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ auth()->user()->getAvatar(64) }}" alt="{{ auth()->user()->name }}" />
              <div>
                <h3 class="text-basefont-semibold text-gray-900">{{ __('Hey :name 👋', ['name' => auth()->user()->name]) }}</h3>
                <p class="text-sm text-gray-500">{{ $viewData['quote'] }}</p>
              </div>
            </div>
          </div>

          <!-- Recent Contacts -->
          <div class="rounded-lg border border-gray-200 bg-white">
            <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2">
              <div class="flex items-center gap-2">
                <x-lucide-users class="h-5 w-5 text-indigo-500" />
                <h3 class="text-sm font-medium text-gray-700">{{ __('Latest persons consulted') }}</h3>
              </div>
            </div>
            <div class="divide-y divide-gray-200">
              @forelse ($viewData['persons'] as $person)
                <div class="flex items-center justify-between px-4 py-2 hover:bg-gray-50">
                  <div class="flex items-center gap-2">
                    <img class="h-7 w-7 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $person['avatar']['40'] }}" srcset="{{ $person['avatar']['40'] }}, {{ $person['avatar']['80'] }} 2x" alt="{{ $person['name'] }}" loading="lazy" />
                    <div>
                      <a href="{{ route('person.show', $person['slug']) }}" class="text-sm font-medium text-gray-900 hover:underline">{{ $person['name'] }}</a>
                    </div>
                  </div>
                  <div class="text-xs text-gray-500">{{ $person['last_consulted_at'] }}</div>
                </div>
              @empty
                <div class="flex flex-col items-center justify-center rounded-lg bg-white p-6 text-center">
                  <span class="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                    <x-lucide-users class="h-6 w-6 text-blue-600" />
                  </span>
                  <p class="text-gray-900">{{ __('No persons consulted yet') }}</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
