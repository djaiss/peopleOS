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
      <a href="{{ route('person.love.new', $person) }}" class="inline-flex cursor-pointer items-center gap-1 rounded-md border border-transparent bg-rose-50 px-2 py-1 text-sm font-medium text-rose-600 hover:border hover:border-rose-300 hover:bg-rose-100 hover:text-rose-600">
        <x-lucide-plus class="h-4 w-4" />
        {{ __('Add relationship') }}
      </a>
  </div>

  @if ($currentRelationships->isEmpty() && $pastRelationships->isEmpty())
    <div class="rounded-lg border border-gray-200 bg-white">
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
          <button wire:click="toggleAddMode" type="button" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-100">
            <x-lucide-plus class="h-4 w-4" />
            {{ __('Add first relationship') }}
          </button>
        </div>
      </div>
    </div>
  @else
    <div class="space-y-4">
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
              <div class="p-4 last:rounded-b-lg" x-data="{
                isNew:
                  {{ isset($relationship['is_new']) && $relationship['is_new'] ? 'true' : 'false' }},
              }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
                <div class="flex items-center gap-3">
                  <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $relationship['person']['id'] }}" alt="" />
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1">
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }} •</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Past Relationships -->
      @if ($pastRelationships->isNotEmpty())
        <div class="rounded-lg border border-gray-200">
          <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
            <div class="flex items-center gap-2">
              <x-lucide-heart-crack class="h-4 w-4 text-gray-500" />
              {{ __('Past relationships') }}
            </div>
          </h3>
          <div class="divide-y divide-gray-200 rounded-b-lg bg-white">
            @foreach ($pastRelationships as $relationship)
              <div class="p-4 last:rounded-b-lg" x-data="{
                isNew:
                  {{ isset($relationship['is_new']) && $relationship['is_new'] ? 'true' : 'false' }},
              }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
                <div class="flex items-center gap-3">
                  <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $relationship['person']['id'] }}" alt="" />
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1">
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }} •</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  @endif
</section>
