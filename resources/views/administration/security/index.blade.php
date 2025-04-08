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

        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Personal API keys') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('Use the API to build your own integration.') }}</p>

        <div id="api-key-notification">
          @if (session('apiKey'))
            <div class="mb-6 rounded-lg border border-green-400 bg-green-50 p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <x-lucide-check-circle class="h-5 w-5 text-green-500" />
                </div>

                <div class="ml-3 w-full">
                  <h3 class="text-sm font-medium text-green-800">{{ __('API Key Created Successfully') }}</h3>

                  <div class="mt-2">
                    <div class="text-sm text-green-700">
                      {{ __('Please copy your API key now. For security reasons, it won\'t be shown again.') }}
                    </div>

                    <div class="mt-3" x-data="{
                      copyToClipboard() {
                        const el = document.createElement('textarea')
                        el.value = '{{ session('apiKey') }}'
                        document.body.appendChild(el)
                        el.select()
                        document.execCommand('copy')
                        document.body.removeChild(el)
                      },
                    }">
                      <div class="flex items-center gap-x-2">
                        <code class="flex-1 rounded bg-white px-3 py-2 font-mono text-sm text-gray-800">{{ session('apiKey') }}</code>
                        <button @click="copyToClipboard()" class="inline-flex items-center rounded-md border border-green-200 bg-white px-3 py-2 text-sm font-semibold text-green-600 shadow-sm hover:bg-green-50 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none">
                          <x-lucide-copy class="mr-1 h-4 w-4" />
                          {{ __('Copy') }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <div id="add-api-key-form" class="flex items-center justify-between rounded-t-lg p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
            @if ($apiKeys->isEmpty())
              <p class="text-sm text-zinc-500">{{ __('No API keys created') }}</p>
            @else
              <p class="text-sm text-zinc-500">{{ __(':count API key(s) created', ['count' => $apiKeys->count()]) }}</p>
            @endif

            <x-button.secondary href="{{ route('administration.security.new') }}" x-target="add-api-key-form" class="mr-2 text-sm">
              {{ __('New API key') }}
            </x-button.secondary>
          </div>

          @if (! $apiKeys->isEmpty())
            <div id="api-key-list">
              @foreach ($apiKeys as $apiKey)
                <div class="group flex items-center justify-between border-b border-gray-200 p-3 first:border-t last:rounded-b-lg last:border-b-0">
                  <div class="flex items-center justify-between gap-3">
                    <div class="rounded-sm bg-zinc-100 p-2">
                      <x-lucide-key class="h-4 w-4 text-zinc-500" />
                    </div>

                    <div class="flex flex-col">
                      <p class="text-sm font-semibold">{{ $apiKey['name'] }}</p>
                      <p class="font-mono text-xs text-zinc-500">{{ $apiKey['last_used'] }}</p>
                    </div>
                  </div>

                  <form x-target="api-key-list" action="{{ route('administration.security.destroy', $apiKey['id']) }}" method="POST" x-on:ajax:before="
                    confirm('Are you sure you want to proceed? This can not be undone.') ||
                      $event.preventDefault()
                  ">
                    @csrf
                    @method('DELETE')

                    <x-button.invisible x-target="api-key-list" class="hidden text-sm group-hover:block">
                      {{ __('Delete') }}
                    </x-button.invisible>
                  </form>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        @include('administration.security.partials.auto-delete-account')
      </div>
    </div>
  </div>
</x-app-layout>
