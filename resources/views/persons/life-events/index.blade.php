<?php
/*
 * @var \App\Models\Person $person
 * @var array $persons
 * @var array $life_events
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
        <!-- title -->
        <div class="mb-4 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <x-lucide-leaf class="h-5 w-5 text-amber-500" />
            <h2 class="text-lg font-semibold text-gray-900">
              {{ __('Life events') }}
            </h2>
          </div>

          <div class="flex items-center gap-2">
            <a x-target="add-life-event-form" href="{{ route('person.life-event.new', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-amber-200 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-300">
              <x-lucide-plus class="mr-1 h-3 w-3" />
              {{ __('Add') }}
            </a>
          </div>
        </div>

        <!-- description -->
        <p class="mb-8 text-sm text-zinc-500">{{ __('Life events are important moments in a person\'s life that you want to remember.') }}</p>

        <!-- add life event form -->
        <div id="add-life-event-form"></div>

        <!-- life events list -->
        @if ($life_events->count() > 0)
          <div id="life-events-list" class="ml-3 flex flex-col gap-y-7 border-l border-gray-300">
            @foreach ($life_events as $lifeEvent)
              <div id="life-event-{{ $lifeEvent['id'] }}" class="relative flex gap-x-3">

                <!-- icon -->
                <div class="absolute -left-3 rounded-full bg-amber-300 p-1">
                  <x-lucide-activity class="h-4 w-4 text-white" />
                </div>

                <!-- description -->
                <div class="relative flex flex-col gap-y-3 pl-6">
                  <div class="group relative">
                    <a x-target="life-event-{{ $lifeEvent['id'] }}" href="{{ route('person.life-event.edit', [$person->slug, $lifeEvent['id']]) }}" class="rounded px-1 group-hover:bg-amber-100">{{ $lifeEvent['description'] }}</a>
                    <span class="ml-1 inline-block text-xs text-gray-500">{{ $lifeEvent['happened_at'] }}</span>

                    <!-- reminder icon, if applicable -->
                    @if ($lifeEvent['has_reminder'])
                      <div class="absolute top-0 -right-8">
                        <x-tooltip text="{{ __('Reminder set') }}">
                          <div class="rounded-full border border-gray-200 bg-white p-1">
                            <x-lucide-bell-ring class="h-3 w-3 text-gray-400" />
                          </div>
                        </x-tooltip>
                      </div>
                    @endif
                  </div>
                  @if ($lifeEvent['comment'])
                    <div class="rounded-lg border border-gray-300 bg-white p-3">{{ $lifeEvent['comment'] }}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div id="life-events-list" class="mb-10 flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
              <x-lucide-leaf class="h-6 w-6 text-amber-500" />
            </div>

            <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No life events yet') }}</h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ __('Remember important moments in a person\'s life.') }}
            </p>
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
