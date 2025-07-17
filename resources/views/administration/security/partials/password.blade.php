<h2 class="font-semi-bold mb-1 text-lg">{{ __('Change password') }}</h2>
<p class="mb-4 text-sm text-zinc-500">{{ __('Make it as secure as it can be.') }}</p>

<form action="{{ route('administration.password.update') }}" method="post" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  @csrf
  @method('put')

  <!-- current password -->
  <div class="grid grid-cols-3 items-center rounded-t-lg border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-input-label for="current_password" :value="__('Current password')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" id="current_password" name="current_password" type="password" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
    </div>
  </div>

  <!-- new password -->
  <div class="grid grid-cols-3 items-center border-b border-gray-200 p-3 hover:bg-blue-50">
    <x-input-label for="new_password" :value="__('New password')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" id="new_password" name="new_password" type="password" required passwordrules="minlength: 8" @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('new_password')" />
      <x-help>{{ __('Minimum 8 characters.') }}</x-help>
    </div>
  </div>

  <!-- confirm new password -->
  <div class="grid grid-cols-3 items-center p-3 hover:bg-blue-50">
    <x-input-label for="new_password_confirmation" :value="__('Confirm new password')" class="col-span-2" />
    <div class="w-full justify-self-end">
      <x-text-input class="block w-full" id="new_password_confirmation" name="new_password_confirmation" type="password" required @focus="showActions = true" @blur="showActions = false" />
      <x-input-error class="mt-2" :messages="$errors->get('new_password_confirmation')" />
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
</form>
