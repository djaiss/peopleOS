<?php
/*
 * @var array $logs
 * @var bool $has_more_logs
 */
?>

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
