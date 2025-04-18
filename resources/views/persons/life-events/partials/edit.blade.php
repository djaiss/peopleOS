<?php
/*
 * @var \App\Models\Person $person
 * @var \App\Models\LifeEvent $lifeEvent
 */
?>

<!-- edit life event form -->
<div id="life-event-{{ $lifeEvent->id }}" class="mb-4 ml-6 w-full rounded-lg border border-gray-200 bg-white">
  <form x-target="life-events-list life-event-{{ $lifeEvent->id }} notifications" x-target.back="life-event-{{ $lifeEvent->id }}" action="{{ route('person.life-event.update', [$person->slug, $lifeEvent->id]) }}" method="POST" class="border-b border-gray-200">
    @csrf
    @method('PUT')

    <div class="flex flex-col gap-y-4 p-4">
      <!-- description -->
      <div>
        <x-input-label for="description" :value="__('Describe what happened')" class="mb-1" />
        <x-text-input class="block w-full" id="description" name="description" type="text" value="{{ $lifeEvent->description }}" required autofocus />
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
      </div>

      <!-- happened at -->
      <div>
        <x-input-label optional for="happened_at" :value="__('Happened at')" />
        <x-text-input id="happened_at" name="happened_at" type="date" class="mt-1 block" required value="{{ $lifeEvent->happened_at->format('Y-m-d') }}" />
        <x-input-error :messages="$errors->get('happened_at')" class="mt-2" />
      </div>

      <!-- comment -->
      <div>
        <x-input-label optional for="comment" :value="__('Comment')" />
        <x-textarea id="comment" name="comment" class="mt-1 block w-full" value="{{ $lifeEvent->comment }}" />
        <x-input-error :messages="$errors->get('comment')" class="mt-2" />
      </div>

      <!-- reminder -->
      <div class="flex gap-2">
        <div class="flex h-6 shrink-0 items-center">
          <div class="group grid size-4 grid-cols-1">
            <input @checked(old('should_be_reminded', $lifeEvent->specialDate?->should_be_reminded)) value="reminded" id="should_be_reminded" name="should_be_reminded" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
          </div>
        </div>
        <div class="text-sm/6">
          <label for="should_be_reminded" class="font-medium text-gray-900">{{ __('Add a yearly reminder') }}</label>
          <x-input-error :messages="$errors->get('should_be_reminded')" class="mt-2" />
        </div>
      </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
      <x-button.secondary x-target="life-event-{{ $lifeEvent->id }}" href="{{ route('person.life-event.index', $person->slug) }}">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>

  <form x-target="life-event-{{ $lifeEvent->id }}" x-on:ajax:before="
    confirm('Are you sure you want to proceed? This can not be undone.') ||
      $event.preventDefault()
  " action="{{ route('person.life-event.destroy', [$person->slug, $lifeEvent->id]) }}" method="POST" class="p-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-offset-2 focus-visible:outline-red-600">
      <x-lucide-trash-2 class="h-4 w-4" />
      {{ __('Delete') }}
    </button>
  </form>
</div>
