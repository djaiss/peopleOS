<?php
/*
 * @var array $logs
 * @var bool $has_more_logs
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
        @include('administration.partials.profile')

        <!-- Profile photo -->
        @include('administration.partials.avatar')

        <!-- Timezone -->
        @include('administration.partials.timezone')

        <!-- Last activity -->
        @include('administration.partials.logs', ['has_more_logs' => $has_more_logs, 'logs' => $logs])
      </div>
    </div>
  </div>
</x-app-layout>
