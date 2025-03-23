<?php
/*
 * @var Person $person
 */
?>

<form x-target="encounters-section" x-target.back="encounters-section" id="add-encounter" action="{{ route('person.encounter.create', $person->slug) }}" method="POST" class="mt-4 rounded-lg border border-gray-200 bg-white">
  @csrf

  <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pt-4 pb-4">
    <div class="">
      <x-input-label for="seen_at" :value="__('Date')" />
      <x-text-input id="seen_at" name="seen_at" type="date" class="mt-1 block w-full" required value="{{ now()->format('Y-m-d') }}" />
      <x-input-error :messages="$errors->get('seen_at')" class="mt-2" />
    </div>

    <div class="flex-1">
      <x-input-label for="context" :value="__('Additional details (optional)')" />
      <x-text-input id="context" name="context" type="text" class="mt-1 block w-full" placeholder="{{ __('e.g. Coffee meeting, Birthday party') }}" />
      <x-input-error :messages="$errors->get('context')" class="mt-2" />
    </div>
  </div>

  <div class="flex items-center justify-between px-4 pb-4">
    <x-button.secondary x-target="encounters-section" href="{{ route('person.show', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
