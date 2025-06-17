<?php
/*
 * @var array $reminders
 */
?>

<div class="rounded-lg border border-gray-200 bg-white">
  <div class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2">
    <div class="flex items-center gap-2">
      <x-lucide-calendar class="h-5 w-5 text-blue-500" />
      <h3 class="text-sm font-medium text-gray-700">{{ __('Reminders in the next 30 days') }}</h3>
    </div>
  </div>
  <div class="divide-y divide-gray-200">
    @forelse ($reminders as $reminder)
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
