<div>
  <form wire:submit="store" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
    <!-- prefix -->
    <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="prefix" :value="__('Prefix')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="prefix" name="prefix" wire:model="prefix" type="text" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('prefix')" />
      </div>
    </div>

    <!-- first name -->
    <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="first_name" :value="__('First name')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="first_name" name="first_name" wire:model="firstName" type="text" required @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
      </div>
    </div>

    <!-- middle name -->
    <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="middle_name" :value="__('Middle name')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="middle_name" name="middle_name" wire:model="middleName" type="text" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
      </div>
    </div>

    <!-- nickname -->
    <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="nickname" :value="__('Nickname')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="nickname" name="nickname" wire:model="nickName" type="text" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
      </div>
    </div>

    <!-- last name -->
    <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="last_name" :value="__('Last name')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="last_name" name="last_name" wire:model="lastName" type="text" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
      </div>
    </div>

    <!-- maiden name -->
    <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="maiden_name" :value="__('Maiden name')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full placeholder-shown:bg-gray-50" id="maiden_name" name="maiden_name" wire:model="maidenName" type="text" placeholder="{{ __('No maiden name defined') }}" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('maiden_name')" />
      </div>
    </div>

    <!-- suffix -->
    <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
      <x-input-label for="suffix" :value="__('Suffix')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <x-text-input class="block w-full" id="suffix" name="suffix" wire:model="suffix" type="text" @focus="showActions = true" @blur="showActions = false" />
        <x-input-error class="mt-2" :messages="$errors->get('suffix')" />
      </div>
    </div>

    <!-- genders -->
    <div class="grid grid-cols-3 items-center rounded-b-lg p-3 hover:bg-blue-50">
      <x-input-label for="gender_id" :value="__('Gender')" class="col-span-2" />
      <div class="w-full justify-self-end">
        <select wire:model="genderId" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" id="gender_id" name="gender_id">
          <option disabled value="">{{ __('Select a gender') }}</option>
          @foreach ($genders as $gender)
            <option value="{{ $gender['id'] }}">{{ $gender['name'] }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
      <x-button.secondary wire:click="toggleAddMode" class="mr-2">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
