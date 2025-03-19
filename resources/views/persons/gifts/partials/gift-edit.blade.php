<?php
/*
 * @var \App\Models\Person $person
 * @var \App\Models\Gift $gift
 */
?>

<form x-target="gift-list notifications" x-target.back="gift-{{ $gift->id }}" id="gift-{{ $gift->id }}" action="{{ route('persons.gifts.update', [$person->slug, $gift->id]) }}" method="POST" class="rounded-lg border-b border-gray-200 bg-white">
  @csrf
  @method('PUT')

  <div class="border-b border-gray-200 px-4 pt-4 pb-4">
    <x-input-label for="name" :value="__('What is this gift?')" class="mb-2" />
    <div class="mb-1 flex items-center gap-x-3">
      <input id="idea" value="idea" name="status" type="radio" @checked($gift->status === 'idea') class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
      <label for="idea" class="block text-sm/6 font-medium text-gray-900">{{ __('An idea') }}</label>
    </div>
    <div class="mb-1 flex items-center gap-x-3">
      <input id="received" value="received" name="status" type="radio" @checked($gift->status === 'received') class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
      <label for="received" class="block text-sm/6 font-medium text-gray-900">{{ __('A gift I\'ve received') }}</label>
    </div>
    <div class="flex items-center gap-x-3">
      <input id="given" value="given" name="status" type="radio" @checked($gift->status === 'given') class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
      <label for="given" class="block text-sm/6 font-medium text-gray-900">{{ __('A gift I\'ve offered') }}</label>
    </div>
  </div>

  <div class="mb-4 flex gap-4 px-4 pt-4">
    <div class="flex-1">
      <x-input-label for="name" :value="__('Name')" class="mb-2" />
      <x-text-input class="block w-full" id="name" name="name" type="text" required data-1p-ignore value="{{ $gift->name }}" />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div class="flex-1">
      <x-input-label optional for="occasion" :value="__('Occasion')" class="mb-1" />
      <x-text-input class="block w-full" id="occasion" name="occasion" type="text" data-1p-ignore value="{{ $gift->occasion }}" />
      <x-input-error :messages="$errors->get('occasion')" class="mt-2" />
    </div>
  </div>

  <div class="mb-4 gap-4 border-b border-gray-200 px-4 pb-4">
    <x-input-label optional for="url" :value="__('URL')" class="mb-1" />
    <x-text-input class="block w-full" id="url" name="url" type="text" value="{{ $gift->url }}" />
    <x-input-error :messages="$errors->get('url')" class="mt-2" />
  </div>

  <!-- Date -->
  <div class="mb-4 px-4" x-data="{
    dateType: '{{ is_null($gift->gifted_at) ? 'unknown' : 'known' }}',
  }">
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-x-3">
        <input id="unknown" value="unknown" name="date" type="radio" x-model="dateType" @checked(is_null($gift->gifted_at)) class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
        <label for="unknown" class="block text-sm/6 font-medium text-gray-900">{{ __('The gift is not for a specific date') }}</label>
      </div>

      <div class="flex items-center gap-x-3">
        <input id="known" value="known" name="date" type="radio" x-model="dateType" @checked(! is_null($gift->gifted_at)) class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
        <label for="known" class="block text-sm/6 font-medium text-gray-900">{{ __('The gift is for a specific date') }}</label>
      </div>
    </div>

    <div x-show="dateType === 'known'" x-transition.duration.100ms class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-3">
      <x-input-label optional for="gifted_at" :value="__('Date')" />
      <x-text-input id="gifted_at" name="gifted_at" type="date" class="mt-1 block" required value="{{ $gift->gifted_at?->format('Y-m-d') }}" />
      <x-input-error :messages="$errors->get('gifted_at')" class="mt-2" />
    </div>
  </div>

  <div class="flex items-center justify-between border-t border-gray-200 px-4 py-4">
    <x-button.secondary x-target="gift-{{ $gift->id }}" href="{{ route('persons.gifts.index', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
