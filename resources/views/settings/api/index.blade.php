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
          {{ __('API') }}
        </li>
      </ul>
    </div>
  </x-slot>

  <main class="relative sm:mt-20">
    <div class="mx-auto max-w-3xl px-2 py-2 sm:px-0 sm:py-6">
      <!-- title + cta -->
      <div class="mb-3 mt-8 items-center justify-between sm:mt-0 sm:flex">
        <h3 class="mb-4 flex font-semibold sm:mb-0">
          <span class="mr-2">👉</span>
          <span>
            {{ __('Manage access keys to use the API') }}
          </span>
        </h3>

        <x-button.secondary href="{{ route('settings.api.new') }}" dusk="add-key" class="flex items-center text-sm">
          <x-heroicon-c-plus class="mr-1 h-4 w-4" />
          <span>{{ __('Add key') }}</span>
        </x-button.secondary>
      </div>

      <!-- help text -->
      <div class="mb-6 flex items-center rounded border bg-slate-50 px-3 py-2 text-sm dark:border-gray-700 dark:bg-slate-900">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 pr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <p>
          {{ __('This is a list of all the keys that let you access your data through the API.') }}
        </p>
      </div>

      <div class="rounded-lg bg-white p-4 shadow dark:bg-gray-800 sm:p-4">
        <!-- new key added, only displayed once -->
        @if (session('key'))
          <div class="mb-3 rounded-lg border-l-2 border-green-300 bg-green-50 p-4 dark:border-green-500 dark:bg-green-900">
            <div>
              <div class="mb-2 text-sm">{{ __('This is the key you just added. Make sure to copy it now, you won\'t be able to see it again.') }}</div>
              <div class="rounded border bg-white px-2 py-1 font-mono text-sm">{{ session('key') }}</div>
            </div>
          </div>
        @endif

        <div hx-target="this" hx-swap="innerHTML" hx-get="{{ route('settings.api.index') }}" hx-trigger="loadTokens from:body">
          @fragment('tokens-list')
            @forelse ($tokens as $token)
              <div class="flex flex-col border border-l-2 border-transparent border-b-gray-200 py-2 last:border-b-0 hover:border-l-2 hover:border-l-blue-300 hover:bg-blue-50 dark:hover:bg-gray-600 sm:flex-row sm:items-center sm:justify-between sm:border-b-0 sm:px-2">
                <div class="mb-2 flex items-center sm:mb-0">
                  <x-heroicon-o-key class="mr-1 h-4 w-4 text-gray-400 dark:text-gray-500" />
                  <span class="font-mono text-sm">{{ $token['name'] }}</span>
                </div>

                <!-- actions -->
                <div class="flex text-sm">
                  <div class="mr-2 text-gray-400">{{ $token['last_used'] }}</div>

                  <div>
                    <span dusk="cta-revoke-key-{{ $token['id'] }}" hx-delete="{{ route('settings.api.destroy', ['key' => $token['id']]) }}" hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' class="cursor-pointer text-red-600 underline hover:no-underline">{{ __('Revoke') }}</span>
                  </div>
                </div>
              </div>
            @empty
              <div>
                <p>{{ __('There are no API keys defined at the moment.') }}</p>
              </div>
            @endforelse
          @endfragment
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
