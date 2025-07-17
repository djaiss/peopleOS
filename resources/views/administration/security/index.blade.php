<?php
/*
 * @var Collection $apiKeys
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
          {{ __('Security & access') }}
        </h1>

        @include('administration.security.partials.password')

        @include('administration.security.partials.2fa')

        @include('administration.security.partials.api-keys', ['apiKeys' => $apiKeys])

        @include('administration.security.partials.auto-delete-account')
      </div>
    </div>
  </div>
</x-app-layout>
