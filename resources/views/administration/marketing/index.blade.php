<?php
/*
 * @var Collection $marketingPages
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
          {{ __('Activity on marketing pages') }}
        </h1>

        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Pages you\'ve rated') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('On the markting website, you can rate pages as helpful or not helpful. This is the complete list of pages you\'ve rated. You can delete them if you want. Your vote on the marketing site is completely anonymous.') }}</p>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <div id="marketing-page-list">
            @forelse ($marketingPages as $marketingPage)
              <div class="group flex items-center justify-between border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0">
                <div class="flex items-center justify-between gap-3">
                  <div class="rounded-sm bg-zinc-100 p-2">
                    @if ($marketingPage['helpful'])
                      <x-lucide-thumbs-up class="h-4 w-4 text-green-700" />
                    @else
                      <x-lucide-thumbs-down class="h-4 w-4 text-red-700" />
                    @endif
                  </div>

                  <div class="flex flex-col">
                    <a href="{{ $marketingPage['url'] }}" target="_blank" class="text-sm font-semibold hover:underline hover:text-blue-500">{{ $marketingPage['url'] }}</a>
                    <p class="font-mono text-xs text-zinc-500">{{ $marketingPage['voted_at'] }}</p>
                  </div>
                </div>

                <form x-target="marketing-page-list" action="{{ route('administration.marketing.destroy', $marketingPage['id']) }}" method="POST" x-on:ajax:before="
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
            @empty
              <div class="flex flex-col items-center justify-center p-6 text-center">
                <div class="mb-3 rounded-full bg-gray-100 p-3">
                  <x-lucide-thumbs-up class="h-6 w-6 text-gray-400" />
                </div>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No rated pages yet') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ __('When you rate pages on the marketing website as helpful or not helpful, they will appear here. This activity is completely anonymous.') }}</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
