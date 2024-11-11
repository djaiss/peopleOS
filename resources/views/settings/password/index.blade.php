<x-settings>
  <div class="border-b border-gray-200 pb-4">
    <h3 class="text-lg font-medium">{{ __('Update your password') }}</h3>
    <p class="text-sm">{{ __('The change is immediate. This does not affect your API tokens, if you have any.') }}</p>
  </div>
  <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- current password -->
    <div class="relative">
      <x-input-label for="current_password" :value="__('Current password')" />
      <x-text-input class="mt-1 block w-full" id="current_password" name="current_password" type="password" required autofocus />
      <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
    </div>

    <!-- new password -->
    <div class="relative">
      <x-input-label for="password" :value="__('New password')" />
      <x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required autofocus />
      <x-input-error class="mt-2" :messages="$errors->get('password')" />
    </div>

    <!-- confirm new password -->
    <div class="relative">
      <x-input-label for="password_confirmation" :value="__('Confirm new password')" />
      <x-text-input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password" required autofocus />
      <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
    </div>

    <div class="flex justify-between pb-4">
      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</x-settings>
