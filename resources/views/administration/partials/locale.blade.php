<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Locale') }}
</h2>

<form action="{{ route('locale.update') }}" method="post" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  @csrf
  @method('put')

  <div class="grid grid-cols-3 items-center rounded-t-lg p-3 last:rounded-b-lg hover:bg-blue-50">
    <x-input-label for="locale" :value="__('Locale')" class="col-span-1" />
    <div class="col-span-2 w-full justify-self-end">
      <select @focus="showActions = true" @blur="showActions = false" id="locale" name="locale" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
        <option value="en" @selected(auth()->user()->locale === 'en')>{{ __('English') }}</option>
        <option value="fr" @selected(auth()->user()->locale === 'fr')>{{ __('French') }}</option>
      </select>

      <x-input-error class="mt-2" :messages="$errors->get('locale')" />
    </div>
  </div>

  <!-- actions -->
  <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
    <x-button.secondary @click="showActions = false" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
