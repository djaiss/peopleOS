<x-settings>
  <div class="border-b border-gray-200 pb-4">
    <h3 class="text-lg font-medium">{{ __('Profile information') }}</h3>
    <p class="text-sm">{{ __('This is your name and personal information.') }}</p>
  </div>
  <form action="{{ route('settings.profile.update') }}" method="POST" class="space-y-5">
    @csrf
    @method('PUT')

    <!-- first name -->
    <div class="relative">
      <x-input-label for="first_name" :value="__('First name')" />
      <x-text-input class="mt-1 block w-full" id="first_name" name="first_name" value="{{ $user->first_name }}" type="text" required autofocus />
      <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
    </div>

    <!-- last name -->
    <div class="relative">
      <x-input-label for="last_name" :value="__('Last name')" />
      <x-text-input class="mt-1 block w-full" id="last_name" name="last_name" value="{{ $user->last_name }}" type="text" required autofocus />
      <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
    </div>

    <div class="relative">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" class="block w-full" type="email" name="email" value="{{ $user->email }}" required autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
      <x-help>{{ __('We will send you a verification email, and won\'t use this email for marketing purposes.') }}</x-help>
    </div>

    <div class="flex justify-between pb-4">
      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</x-settings>
