<?php
/**
 * @var array $vaults
 * @var array $routes
 */
?>

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
            <x-button.primary href="{{ $routes['vault']['new'] }}" dusk="create-vault-no-vaults">
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
        <x-button.primary href="{{ $routes['vault']['new'] }}" hover dusk="">
          {{ __('New vault') }}
        </x-button.primary>
      </div>

      <div class="flex bg-white shadow sm:rounded-lg">
        <ul class="w-full">
          @foreach ($vaults as $vault)
            <li class="border-b border-gray-200 px-6 py-4 last:border-b-0 hover:bg-slate-50 first:hover:rounded-t-lg last:hover:rounded-b-lg">
              <div class="flex items-center justify-between">
                <div class="mr-6 flex flex-col">
                  <div class="flex items-center">
                    <x-link href="{{ $vault['routes']['vault']['show'] }}">{{ $vault['name'] }}</x-link>
                  </div>
                  <div class="mt-2 flex items-center">
                    <div class="mr-5 flex">
                      <x-lucide-activity class="mr-1 w-3 text-gray-500" />

                      <p class="text-sm text-gray-600">
                        {{ $vault['updated_at'] }}
                      </p>
                    </div>

                    <p class="mr-4 text-sm text-gray-600">
                      @if ($vault['description'])
                        {{ $vault['description'] }}
                      @else
                        {{ __('No description yet.') }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif
</x-app-layout>
