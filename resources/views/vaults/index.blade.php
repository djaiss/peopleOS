<x-app-layout>
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
</x-app-layout>
