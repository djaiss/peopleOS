<x-app-layout>
  <x-slot name="breadcrumb">
    <div class="flex text-sm">
      <p class="mr-2">{{ __('You are here:') }}</p>
      <ul>
        <li class="inline">
          {{ __('Settings') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-10">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0">
      <div class="hidden space-y-6 pb-16 md:block">
        <div class="space-y-0.5">
          <h2 class="text-2xl font-bold tracking-tight">{{ __('Update password') }}</h2>
          <p class="">{{ __('This will immediately affect your login.') }}</p>
        </div>

        <div class="flex flex-col space-y-8 bg-white shadow sm:rounded-lg lg:flex-row lg:space-x-12 lg:space-y-0">
          <aside class="px-4 lg:w-1/5">
            @include('settings.partials.navigation')
          </aside>
          <div class="flex-1 py-3 lg:max-w-2xl">
            <div class="space-y-6">
              <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-medium">{{ __('Profile information') }}</h3>
                <p class="text-sm">{{ __('This is your name and personal information.') }}</p>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
