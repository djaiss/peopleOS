<?php
/*
 * @var array $genders
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px_1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Personalization') }}
        </h1>

        @include('administration.personalization.partials.genders', ['genders' => $genders])

        <h2 class="font-semi-bold mb-1 text-lg">
          {{ __('All the marital statuses in the account') }}
        </h2>

        <p class="mb-4 text-sm text-zinc-500">
          {{ __('You can drag and drop the marital statuses to change their order.') }}
        </p>

        {{-- <livewire:administration.personalization.manage-marital-statuses /> --}}
      </div>
    </div>
  </div>
</x-app-layout>
