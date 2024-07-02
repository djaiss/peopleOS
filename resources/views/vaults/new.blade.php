<x-app-layout>
  <!-- breadcrumb -->
  <x-slot name="breadcrumb">
    <ul class="text-sm">
      <li class="me-2 inline">
        {{ __('You are here:') }}
      </li>
      <li class="me-2 inline">
        <x-link href="{{ route('vaults.index') }}">
          {{ __('All the vaults') }}
        </x-link>
      </li>
      <li class="inline">
        {{ __('Add a vault') }}
      </li>
    </ul>
  </x-slot>

  <main class="relative mt-16 sm:mt-24">
    <div class="mx-auto max-w-lg px-2 py-2 sm:px-6 sm:py-6 lg:px-8">
      <form class="mb-6 rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
        <div class="section-head border-b border-gray-200 bg-blue-50 p-3 sm:p-5 dark:border-gray-700 dark:bg-blue-900">
          <h1 class="mb-1 flex justify-center text-2xl font-medium">
            <span>{{ __('Create a vault') }}</span>

            <help :url="$page.props.help_links.vault_create" :top="'9px'" :class="'ms-2'" />
          </h1>
          <p class="text-center text-sm">
            {{ __('Vaults contain all your contacts data.') }}
          </p>
        </div>

        <div class="border-b border-gray-200 px-5 dark:border-gray-700">
          <!-- title -->
          <div class="relative py-4">
            <x-input-label for="title" :value="__('Name')" />

            <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" required autofocus />

            <x-input-error class="mt-2" :messages="$errors->get('title')" />
          </div>

          <!-- description -->
          <div class="relative pb-4 pt-2">
            <x-input-label for="description" :value="__('Description')" :optional="true" />

            <x-textarea id="description" name="description" required :height="'min-h-[100px]'" class="mt-2 block w-full" type="text">{{ old('description') }}</x-textarea>

            <x-input-error class="mt-2" :messages="$errors->get('description')" />
          </div>
        </div>

        <div class="flex justify-between p-5">
          <x-button.secondary href="{{ route('vaults.index') }}">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary>
            {{ __('Create') }}
          </x-button.primary>
        </div>
      </form>
    </div>
  </main>
</x-app-layout>
