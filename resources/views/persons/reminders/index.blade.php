<?php
/*
 * @var array $persons
 * @var \App\Models\Person $person
 * @var array $months
 * @var int $totalReminders
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.persons-list', ['persons' => $persons, 'person' => $person])

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="mx-auto max-w-2xl p-6">
        <!-- Header -->
        <div class="mb-2 flex items-center justify-between">
          <h1 class="font-semi-bold mb-4 text-2xl">{{ __('Yearly reminders') }}</h1>
          <span class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-600">
            {{ __(':count active', ['count' => $totalReminders]) }}
          </span>
        </div>

        <!-- Months Grid -->
        <div class="space-y-6">
          @foreach ($months as $month)
            <div class="rounded-lg border border-gray-200 bg-white">
              <!-- Month Header -->
              <div class="bg-{{ $month['color'] }}-50 rounded-t-lg border-b border-gray-200 px-4 py-3">
                <h2 class="text-{{ $month['color'] }}-700 font-semibold">{{ $month['name'] }}</h2>
              </div>

              <!-- Reminders List -->
              <div class="divide-y divide-gray-200">
                @forelse ($month['reminders'] as $reminder)
                  <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-4">
                      <div class="bg-{{ $month['color'] }}-100 flex h-10 w-10 items-center justify-center rounded-full">
                        {{ $reminder['day'] == 0 ? 1 : $reminder['day'] }}
                      </div>
                      <div>
                        <p class="font-medium text-gray-900">{{ $reminder['name'] }}</p>
                        <p class="text-sm text-gray-500">{{ $reminder['date'] }} ({{ $reminder['age'] }})</p>
                      </div>
                    </div>

                    <div class="flex items-center gap-2">
                      <form x-target="reminder-{{ $reminder['id'] }}" id="reminder-{{ $reminder['id'] }}" action="{{ route('persons.reminders.test', ['slug' => $person->slug, 'specialDate' => $reminder['id']]) }}" method="POST">
                        @csrf

                        <x-tooltip text="{{ __('Send a test reminder') }}">
                          <button type="submit" class="bg-{{ $month['color'] }}-50 text-{{ $month['color'] }}-600 hover:bg-{{ $month['color'] }}-100 cursor-pointer rounded-md p-2">
                            <x-lucide-mail class="h-4 w-4" />
                          </button>
                        </x-tooltip>
                      </form>
                    </div>
                  </div>
                @empty
                  <div class="flex items-center justify-center p-6 text-center">
                    <div class="max-w-sm">
                      <x-lucide-calendar class="mx-auto h-6 w-6 text-gray-400" />
                      <p class="mt-2 text-sm text-gray-600">{{ __('No reminders in :month', ['month' => $month['name']]) }}</p>
                    </div>
                  </div>
                @endforelse
              </div>
            </div>
          @endforeach

          <!-- Empty State (when no reminders at all) -->
          @if ($totalReminders === 0)
            <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center">
              <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <x-lucide-bell class="h-6 w-6 text-blue-600" />
              </div>

              <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No reminders yet') }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ __('Set up reminders for birthdays, anniversaries, and other important dates to never miss a special occasion.') }}
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
