<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul class="text-sm">
        <li class="inline after:text-xs after:text-gray-500 after:content-['>']">
          <x-link href="{{ route('settings.index') }}">
            {{ __('Settings') }}
          </x-link>
        </li>
        <li class="inline">
          {{ __('Update profile') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-20">
    <!-- profile information -->
    <div class="mx-auto max-w-3xl px-2 py-2 sm:px-0 sm:py-6">
      <!-- title + cta -->
      <div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
        <h3 class="mb-4 flex font-semibold sm:mb-0">
          {{ __('Profile information') }}
        </h3>
      </div>

      <form action="{{ route('settings.profile.update') }}" method="POST" class="rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
        @csrf
        @method('PUT')

        <div class="mb-4 grid grid-flow-row gap-4 px-4 pt-4 sm:grid-flow-col sm:grid-cols-2">
          <div>
            <x-input-label for="first_name" :value="__('First name')" />
            <x-text-input id="first_name" class="block w-full" type="text" name="first_name" :value="old('first_name', auth()->user()->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
          </div>

          <div>
            <x-input-label for="last_name" :value="__('Last name')" />
            <x-text-input id="last_name" class="block w-full" type="text" name="last_name" :value="old('last_name', auth()->user()->last_name)" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
          </div>
        </div>

        <div class="border-b border-gray-200 px-4 pb-4">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', auth()->user()->email)" required autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
          <x-help>{{ __(' We will send you a verification email, and won\'t spam you.') }}</x-help>
        </div>

        <div class="flex justify-between p-5">
          <x-button.secondary dusk="profile-submit-form-button">
            {{ __('Save') }}
          </x-button.secondary>
        </div>
      </form>
    </div>

    <!-- password change -->
    <div class="mx-auto max-w-3xl px-2 py-2 sm:px-0 sm:py-6">
      <!-- title + cta -->
      <div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
        <h3 class="mb-4 flex font-semibold sm:mb-0">
          {{ __('Update password') }}
        </h3>
      </div>

      <form action="{{ route('settings.password.update') }}" method="POST" class="mb-6 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
        @csrf
        @method('PUT')

        <div class="mb-4 px-4 pt-4">
          <x-input-label for="update_password_current_password" :value="__('Current Password')" />
          <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
          <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-flow-row gap-4 border-b border-gray-200 px-4 pb-4 sm:grid-flow-col sm:grid-cols-2">
          <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
          </div>

          <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
          </div>
        </div>

        <div class="flex justify-between p-5">
          <x-button.secondary dusk="password-submit-form-button">
            {{ __('Save') }}
          </x-button.secondary>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
