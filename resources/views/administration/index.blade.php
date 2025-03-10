<?php
/*
 * @var array $logs
 * @var bool $has_more_logs
 * @var \App\Models\User $user
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-1 lg:grid-cols-[240px_1fr]">
    <!-- sidebar -->
    @include('administration.partials.sidebar')

    <!-- main content -->
    <div class="relative bg-gray-50 px-6 pt-8 lg:px-12">
      <div class="mx-auto max-w-2xl px-2 py-2 sm:px-0">
        <!-- Profile -->
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Profile') }}
        </h1>

        @include('administration.partials.profile', ['user' => $user])

        <!-- Profile photo -->
        <h2 class="font-semi-bold mb-1 text-lg">{{ __('Profile photo') }}</h2>
        <p class="mb-4 text-sm text-zinc-500">{{ __('You can upload a profile photo to use as your avatar, or use the default avatar.') }}</p>

        @include('administration.partials.avatar', ['user' => $user])

        <!-- Last activity -->
        <h2 class="font-semi-bold mb-4 text-lg">
          {{ __('Last activity') }}
        </h2>

        <div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <!-- last actions -->
          @foreach ($logs as $log)
            <div class="flex items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
              <div class="flex items-center gap-3">
                <x-lucide-activity class="size-3 min-w-3 text-zinc-600 dark:text-zinc-400" />
                <div class="">
                  <p class="flex items-center gap-1">
                    <span class="">{{ $log['user']['name'] }}</span>
                    |
                    <span class="font-mono text-xs">{{ $log['action'] }}</span>
                  </p>
                  <p>{{ $log['description'] }}</p>
                </div>
              </div>

              <p class="font-mono text-xs">{{ $log['created_at'] }}</p>
            </div>
          @endforeach

          @if ($has_more_logs)
            <div class="flex justify-center rounded-b-lg p-3 text-sm hover:bg-blue-50">
              <x-link href="{{ route('administration.logs.index') }}" class="text-center">{{ __('Browse all activity') }}</x-link>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
