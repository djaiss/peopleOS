<?php
/*
 * @var Person $person
 */
?>

<!-- add life event form -->
<form x-data="{ showHappenedAtDate: false, showComment: false }" x-target="life-events-list add-life-event-form notifications" x-target.back="add-life-event-form" id="add-life-event-form" action="{{ route('person.life-event.create', $person->slug) }}" method="POST" class="mb-8 rounded-lg border border-gray-200 bg-white">
  @csrf

  <!-- Hidden fields to track shown sections -->
  <input type="checkbox" name="has_happened_at_date" x-bind:checked="showHappenedAtDate" class="hidden" />

  <div class="flex flex-col gap-y-4 p-4">
    <!-- description -->
    <div>
      <x-input-label for="description" :value="__('Describe what happened')" class="mb-1" />
      <x-text-input class="block w-full" id="description" name="description" type="text" value="{{ old('description') }}" required autofocus />
      <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <!-- toggles -->
    <div x-show="!showHappenedAtDate || !showComment" class="flex gap-2">
      <!-- happened date toggle -->
      <div x-show="!showHappenedAtDate" @click="showHappenedAtDate = true" class="flex cursor-pointer items-center gap-2 rounded-md border border-transparent bg-gray-50 p-1 text-sm text-gray-500 shadow-xs hover:border-gray-300">
        <x-lucide-calendar class="h-4 w-4" />
        <span>{{ __('Happened today') }}</span>
      </div>

      <!-- add comment toggle -->
      <div x-show="!showComment" @click="showComment = true" class="flex cursor-pointer items-center gap-2 rounded-md border border-transparent bg-gray-50 p-1 text-sm text-gray-500 shadow-xs hover:border-gray-300">
        <x-lucide-message-circle-plus class="h-4 w-4" />
        <span>{{ __('Add a comment') }}</span>
      </div>
    </div>

    <!-- happened at -->
    <div x-show="showHappenedAtDate" x-cloak class="">
      <x-input-label optional for="happened_at" :value="__('Happened at')" />
      <x-text-input id="happened_at" name="happened_at" type="date" class="mt-1 block" required value="{{ now()->format('Y-m-d') }}" />
      <x-input-error :messages="$errors->get('happened_at')" class="mt-2" />
    </div>

    <!-- comment -->
    <div x-show="showComment" x-cloak>
      <x-input-label optional for="comment" :value="__('Comment')" />
      <x-textarea id="comment" name="comment" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('comment')" class="mt-2" />
    </div>
  </div>

  <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
    <x-button.secondary x-target="add-life-event-form" href="{{ route('person.life-event.index', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
