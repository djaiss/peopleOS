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

        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Personal API keys') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('Use the API to build your own integration.') }}</p>

        {{-- <livewire:administration.security.manage-api-keys lazy /> --}}
      </div>
    </div>
  </div>
</x-app-layout>
