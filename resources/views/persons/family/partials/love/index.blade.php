<?php
/*
 * @var Person $person
 * @var Collection $currentRelationships
 * @var Collection $pastRelationships
 */
?>

<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-heart class="h-5 w-5 text-rose-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Love & romance') }}</h2>
    </div>
    <a x-target="new-love-relationship" href="{{ route('person.love.new', $person) }}" class="inline-flex cursor-pointer items-center gap-1 rounded-md border border-transparent bg-rose-50 px-2 py-1 text-sm font-medium text-rose-600 hover:border hover:border-rose-300 hover:bg-rose-100 hover:text-rose-600">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add relationship') }}
    </a>
  </div>

  @if ($currentRelationships->isEmpty() && $pastRelationships->isEmpty())
    <div id="new-love-relationship" class="rounded-lg border border-gray-200 bg-white">
      <div class="flex flex-col items-center justify-center p-8 text-center">
        <!-- Decorative heart icon -->
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
          <x-lucide-heart class="h-6 w-6 text-rose-600" />
        </div>

        <!-- Text content -->
        <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('No relationships recorded') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of romantic relationships, past and present.') }}</p>

        <!-- Call to action -->
        <div class="mt-6">
          <a x-target="new-love-relationship" href="{{ route('person.love.new', $person) }}" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-100">
            <x-lucide-plus class="h-4 w-4" />
            {{ __('Add first relationship') }}
          </a>
        </div>
      </div>
    </div>
  @else
    <div id="new-love-relationship"></div>

    <div id="love-listing" class="space-y-4">
      @if ($currentRelationships->isNotEmpty())
        <!-- Current relationships -->
        <div class="rounded-lg border border-gray-200">
          <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
            <div class="flex items-center gap-2">
              <x-lucide-gem class="h-4 w-4 text-rose-500" />
              {{ __('Current relationships') }}
            </div>
          </h3>
          <div class="divide-y divide-gray-200 rounded-b-lg bg-white">
            @foreach ($currentRelationships as $relationship)
              <div id="current-love-relationship-{{ $relationship['id'] }}" class="group flex items-center justify-between p-4 last:rounded-b-lg">
                <div class="flex items-center gap-3">
                  <div class="shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $relationship['person']['avatar']['40'] }}" srcset="{{ $relationship['person']['avatar']['40'] }}, {{ $relationship['person']['avatar']['80'] }} 2x" alt="{{ $relationship['person']['name'] }}" loading="lazy" />
                  </div>
                  <div class="min-w-0 flex-1">
                    @if ($relationship['person']['is_listed'])
                      <a href="{{ route('person.show', $relationship['person']['slug']) }}" class="truncate font-medium text-gray-900 underline">{{ $relationship['person']['name'] }}</a>
                    @else
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    @endif
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }}</p>
                  </div>
                </div>

                <div class="flex gap-0">
                  {{--
                    <x-button.invisible x-target="past-love-relationship-{{ $relationship['id'] }}" href="{{ route('person.love.edit', [$person->slug, $relationship['id']]) }}" class="hidden text-sm group-hover:block">
                    {{ __('Edit') }}
                    </x-button.invisible>
                  --}}

                  <form x-target="current-love-relationship-{{ $relationship['id'] }}" x-on:ajax:before="
                    confirm('Are you sure you want to proceed? This can not be undone.') ||
                      $event.preventDefault()
                  " action="{{ route('person.love.destroy', [$person->slug, $relationship['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <x-button.invisible class="hidden text-sm group-hover:block">
                      {{ __('Delete') }}
                    </x-button.invisible>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Past Relationships -->
      @if ($pastRelationships->isNotEmpty())
        <div id="past-love-relationships" class="rounded-lg border border-gray-200" x-data="{
          pastRelationshipsExpanded:
            {{ $person->show_past_love_relationships ? 'true' : 'false' }},
        }">
          <div class="flex items-center justify-between rounded-t-lg bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
            <!-- title -->
            <div class="flex items-center gap-2">
              <x-lucide-heart-crack class="h-4 w-4 text-gray-500" />
              {{ __('Past relationships') }}
            </div>

            <!-- show/hide -->
            <div class="flex items-center gap-2">
              <a x-target="past-love-relationships" href="{{ route('person.love.toggle', $person->slug) }}" class="inline-flex cursor-pointer items-center gap-1 rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-600 hover:bg-gray-200">
                <span x-text="pastRelationshipsExpanded ? '{{ __('Show less') }}' : '{{ __('Show more') }}'"></span>
                <x-lucide-chevron-down x-show="!pastRelationshipsExpanded" class="h-4 w-4" />
                <x-lucide-chevron-up x-show="pastRelationshipsExpanded" class="h-4 w-4" />
              </a>
            </div>
          </div>

          <!-- list -->
          <div x-cloak x-show="pastRelationshipsExpanded" class="divide-y divide-gray-200 rounded-b-lg border-t border-gray-200 bg-white">
            @foreach ($pastRelationships as $relationship)
              <div id="past-love-relationship-{{ $relationship['id'] }}" class="group flex items-center justify-between p-4 last:rounded-b-lg">
                <div class="flex items-center gap-3">
                  <div class="shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $relationship['person']['avatar']['40'] }}" srcset="{{ $relationship['person']['avatar']['40'] }}, {{ $relationship['person']['avatar']['80'] }} 2x" alt="{{ $relationship['person']['name'] }}" loading="lazy" />
                  </div>
                  <div class="min-w-0 flex-1">
                    @if ($relationship['person']['is_listed'])
                      <a href="{{ route('person.show', $relationship['person']['slug']) }}" class="truncate font-medium text-gray-900 underline">{{ $relationship['person']['name'] }}</a>
                    @else
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    @endif
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }}</p>
                  </div>
                </div>
                <div class="flex gap-0">
                  {{--
                    <x-button.invisible x-target="past-love-relationship-{{ $relationship['id'] }}" href="{{ route('person.love.edit', [$person->slug, $relationship['id']]) }}" class="hidden text-sm group-hover:block">
                    {{ __('Edit') }}
                    </x-button.invisible>
                  --}}

                  <form x-target="past-love-relationship-{{ $relationship['id'] }}" x-on:ajax:before="
                    confirm('Are you sure you want to proceed? This can not be undone.') ||
                      $event.preventDefault()
                  " action="{{ route('person.love.destroy', [$person->slug, $relationship['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <x-button.invisible class="hidden text-sm group-hover:block">
                      {{ __('Delete') }}
                    </x-button.invisible>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  @endif
</section>
