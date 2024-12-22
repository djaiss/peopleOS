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
      <div class="space-y-6 pb-16 md:block">
        <div class="space-y-0.5">
          <h2 class="text-2xl font-bold tracking-tight">{{ __('Settings') }}</h2>
          <p class="">{{ __('Manage your account settings.') }}</p>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
