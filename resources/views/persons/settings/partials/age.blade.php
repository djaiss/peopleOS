<?php
/*
 * @var \App\Models\Person $person
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Edit age') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('Perhaps you do not know the exact dates, but that is ok.') }}
</p>

<form action="{{ route('person.settings.avatar.age', ['slug' => $person->slug]) }}" method="post">
  @method('PUT')
  @csrf

  <div class="mb-8 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-blue-900" x-data="{
    selectedAge: '{{ $person->age_type }}',
    showActions: false,
  }">
    <!-- unknown -->
    <div class="flex items-center gap-x-3 border-b border-gray-200 p-3 dark:border-gray-700">
      <input id="unknown" value="unknown" name="age" type="radio" @checked($person->age_type == 'unknown') x-on:click="selectedAge = 'unknown'; showActions = true" class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
      <label for="unknown" class="block text-sm/6 font-medium text-gray-900">{{ __('Unknown') }}</label>
    </div>

    <!-- approximate age -->
    <div class="flex flex-col gap-y-2 border-b border-gray-200 p-3 dark:border-gray-700">
      <div class="flex items-center gap-x-3">
        <input id="estimated" value="estimated" name="age" type="radio" @checked($person->age_type == 'estimated') x-on:click="selectedAge = 'estimated'; showActions = true" class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
        <label for="estimated" class="block text-sm/6 font-medium text-gray-900">{{ __('I know an approximate age') }}</label>
      </div>
      <div x-show="selectedAge == 'estimated'" class="ml-6">
        <x-text-input class="mt-1 block" id="estimated_age" name="estimated_age" type="number" min="1" max="100" value="{{ $person?->estimated_age }}" />
        <x-input-error class="mt-2" :messages="$errors->get('estimated_age')" />
        <x-help>{{ __('We\'ll increment the year automatically every year so you can always be sure that the age is correct.') }}</x-help>
      </div>
    </div>

    <!-- exact birthdate -->
    <div class="flex items-center gap-x-3 p-3">
      <input id="exact" value="exact" name="age" type="radio" @checked($person->age_type == 'exact') x-on:click="selectedAge = 'exact'; showActions = true" class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden" />
      <label for="exact" class="block text-sm/6 font-medium text-gray-900">{{ __('I know the exact birthdate') }}</label>

      <div x-show="selectedAge == 'exact'" class="ml-6">
        <x-text-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full" value="{{ $person->ageSpecialDate?->dateAsString() }}" />
        <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
      </div>
    </div>

    <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
      <x-button.secondary @click="showActions = false" class="mr-2">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </div>
</form>
