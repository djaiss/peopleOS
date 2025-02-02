<form wire:submit="store" @store-complete.window="showActions = false" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  <!-- email -->
  <div class="grid grid-cols-3 items-center p-3 hover:rounded-t-lg hover:bg-blue-50">
    <x-input-label for="email" :value="__('Email')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" wire:model="email" id="email" name="email" type="email" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>
  </div>

  <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
    <x-button.secondary @click="showActions = false" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Send invitation') }}
    </x-button.primary>
  </div>
</form>
