<?php
/*
 * @var array $reminders
 * @var array $persons
 * @var string $quote
 * @var array $tasks
 */
?>

<x-app-layout>
  <div class="min-h-screen bg-gray-50">
    <x-slot name="header">
      <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">
        {{ __('Dashboard') }}
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
          <!-- Left column -->
          <div>
            <!-- reminders -->
            @include('dashboard.partials.reminders', ['reminders' => $reminders])
          </div>

          <!-- Middle column -->
          <div>
            @include('dashboard.partials.tasks', ['tasks' => $tasks])
          </div>

          <!-- Right column -->
          <div class="space-y-6">
            <!-- Welcome box -->
            <div class="rounded-lg border border-gray-200 bg-white p-4">
              <div class="flex items-center gap-3">
                <x-image class="h-12 w-12 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ auth()->user()->getAvatar(64) }}" alt="{{ auth()->user()->name }}" />
                <div>
                  <h3 class="text-base font-semibold text-gray-900">
                    {{ __('Hey :name 👋', ['name' => auth()->user()->name]) }}
                  </h3>
                  <p class="text-sm text-gray-500">{{ $quote }}</p>
                </div>
              </div>
            </div>

            <!-- Recent contacts -->
            <div class="rounded-lg border border-gray-200 bg-white">
              <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2">
                <div class="flex items-center gap-2">
                  <x-lucide-users class="h-5 w-5 text-indigo-500" />
                  <h3 class="text-sm font-medium text-gray-700">{{ __('Latest persons consulted') }}</h3>
                </div>
              </div>
              <div class="divide-y divide-gray-200">
                @forelse ($persons as $person)
                  <div class="flex items-center justify-between px-4 py-2 hover:bg-gray-50">
                    <div class="flex items-center gap-2">
                      <x-image class="h-7 w-7 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $person['avatar']['40'] }}" srcset="{{ $person['avatar']['40'] }}, {{ $person['avatar']['80'] }} 2x" alt="{{ $person['name'] }}" />
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
  </div>
</x-app-layout>
