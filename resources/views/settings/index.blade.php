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

  <main class="relative sm:mt-20">
    <div class="mx-auto max-w-md px-2 py-2 sm:px-0 sm:py-6">
      <!-- user settings -->
      <h2 class="mb-6 text-center text-lg">
        {{ __('User settings') }}
      </h2>

      <div class="mb-12 rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
        <ul>
          <li class="mb-2 flex justify-start">
            <span class="me-2">🥳</span>
            <x-link href="{{ route('settings.preferences.index') }}" class="text-blue-500 hover:underline">
              {{ __('User preferences') }}
            </x-link>
          </li>
          <li class="mb-2 flex justify-start">
            <span class="me-2">📡</span>
            <x-link href="'data.url.notifications.index'" class="text-blue-500 hover:underline">
              {{ __('Notification channels') }}
            </x-link>
          </li>
          <li class="mb-2 flex justify-start">
            <span class="me-2">🔐</span>
            <x-link href="{{ route('settings.profile.index') }}" class="text-blue-500 hover:underline" dusk="profile-link">
              {{ __('Profile and security') }}
            </x-link>
          </li>
          <li class="flex justify-start">
            <span class="me-2">⚓</span>
            <x-link href="'route('api-tokens.index')'" class="text-blue-500 hover:underline">
              {{ __('API Tokens') }}
            </x-link>
          </li>
        </ul>
      </div>

      <!-- account settings -->
      <div v-if="data.is_account_administrator">
        <h2 class="mb-6 text-center text-lg">
          {{ __('Account settings') }}
        </h2>
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
          <ul>
            <li class="mb-2 flex justify-start">
              <span class="me-2">😀</span>
              <x-link href="'data.url.users.index'" class="text-blue-500 hover:underline">
                {{ __('Manage users') }}
              </x-link>
            </li>
            <li class="mb-2 flex justify-start">
              <span class="me-2">🎃</span>
              <x-link href="'data.url.personalize.index'" class="text-blue-500 hover:underline">
                {{ __('Personalize your account') }}
              </x-link>
            </li>
            <li class="mb-2 flex justify-start">
              <span class="me-2">📸</span>
              <x-link href="'data.url.storage.index'" class="text-blue-500 hover:underline">
                {{ __('Manage storage') }}
              </x-link>
            </li>
            <li class="flex justify-start">
              <span class="me-2">💩</span>
              <x-link href="'data.url.cancel.index'" class="text-blue-500 hover:underline">
                {{ __('Cancel your account') }}
              </x-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
