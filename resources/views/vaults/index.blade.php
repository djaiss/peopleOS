<x-app-layout>
  @if (count($vaults) == 0)
    <main class="relative mt-16 sm:mt-10">
      <div class="mx-auto mb-6 max-w-md px-2 py-2 sm:px-6 sm:py-6 lg:px-8">
        <div class="rounded-t-lg border-x border-t border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
          <p class="mb-2 text-center text-xl">👋</p>
          <h2 class="mb-6 text-center text-lg font-semibold">
            {{ __('Thanks for giving Monica a try.') }}
          </h2>
          <p class="mb-3">
            {{ __('Monica was made to help you document your life and your social interactions.') }}
          </p>
          <p class="mb-5">
            {{ __('To start, you need to create a vault. This lets you store your contacts and all your information.') }}
          </p>
          <div class="mb-2 text-center">
            <x-button.primary href="{{ route('vaults.new') }}">
              {{ __('Create a vault') }}
            </x-button.primary>
          </div>
        </div>

        <div class="rounded-b-lg border border-gray-200 bg-slate-50 p-5 dark:border-gray-700 dark:bg-slate-900">
          <p class="mb-3">
            {{ __('Monica is open source, made by hundreds of people from all around the world.') }}
          </p>
          <p class="mb-3">
            {{ __('We hope you will like what we’ve done.') }}
          </p>
          <p class="mb-3">
            {{ __('All the best,') }}
          </p>
          <p>
            <a href="https://phpc.social/@regis" rel="noopener noreferrer" class="text-blue-500 hover:underline">Régis</a>
            &amp;
            <a href="https://mamot.fr/@asbin" rel="noopener noreferrer" class="text-blue-500 hover:underline">Alexis</a>
          </p>
        </div>
      </div>
    </main>
  @else
    <div class="mx-auto max-w-4xl px-2 py-2 sm:px-6 sm:py-6 lg:px-8">
      <div class="mb-10 items-center justify-between sm:mb-6 sm:flex">
        <h3 class="mb-3 sm:mb-0 dark:text-slate-200">
          {{ __('All the vaults in the account') }}
        </h3>
        <x-button.secondary href="{{ route('vaults.new') }}">
          {{ __('Create a vault') }}
        </x-button.secondary>
      </div>

      <div class="vault-list grid grid-cols-1 gap-6 sm:grid-cols-3">
        @foreach ($vaults as $vault)
          <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div class="vault-detail grid">
              <x-link href="'vault.url.show'" class="border-b border-gray-200 px-3 py-1 hover:rounded-t-lg hover:bg-slate-50 dark:border-gray-700 dark:bg-slate-900 dark:text-gray-300 hover:dark:bg-slate-800">
                {{ $vault['name'] }}
              </x-link>

              <!-- description -->
              <div>
                @if ($vault['description'])
                  <p class="p-3 dark:text-gray-300">
                    {{ $vault['description'] }}
                  </p>
                @else
                  <p class="p-3 text-gray-500">
                    {{ __('No description yet.') }}
                  </p>
                @endif
              </div>

              <!-- actions -->
              <div class="flex items-center justify-between border-t border-gray-200 px-3 py-2 dark:border-gray-700">
                {{--
                  <InertiaLink :href="vault.url.settings">
                  <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="pointer h-5 w-5 text-gray-400 hover:text-gray-900 dark:text-gray-600 hover:dark:text-gray-100"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  </InertiaLink>
                  
                  <InertiaLink :href="vault.url.show">
                  <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="pointer h-5 w-5 text-gray-400 hover:text-gray-900 dark:text-gray-600 hover:dark:text-gray-100"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor">
                  <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 7l5 5m0 0l-5 5m5-5H6" />
                  </svg>
                  </InertiaLink>
                --}}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif
</x-app-layout>
