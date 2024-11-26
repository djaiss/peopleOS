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
          {{ __('Personalization') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-10">
    <div class="mx-auto max-w-7xl px-2 py-2 sm:px-0">
      <div class="hidden space-y-6 pb-16 md:block">
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
                <h3 class="text-lg font-medium">{{ __('Personalization') }}</h3>
                <p class="text-sm">{{ __('Personalize your experience and preferences.') }}</p>
              </div>
              <div class="space-y-6">
                <livewire:settings.manage-genders lazy :account-id="auth()->user()->account_id" />

                <livewire:settings.manage-ethnicities lazy :account-id="auth()->user()->account_id" />

                <livewire:settings.manage-marital-statuses lazy :account-id="auth()->user()->account_id" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
