<?php
/*
 * @var Collection $cancellationReasons
 */
?>

<x-app-layout>
  <!-- Admin panel indicator -->
  <div class="border-b border-yellow-200 bg-yellow-50">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-x-3 px-4 py-2 sm:px-6 lg:px-8">
      <x-lucide-shield class="h-4 w-4 text-yellow-600" />
      <span class="text-sm font-medium text-yellow-800">{{ __('Instance administration area') }}</span>
    </div>
  </div>

  <!-- Breadcrumb -->
  <nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center gap-x-3 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex items-center gap-x-3 text-sm text-gray-500">
        <a href="{{ route('dashboard.index') }}" class="hover:text-gray-700">{{ __('Dashboard') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <a href="{{ route('instance.index') }}" class="hover:text-gray-700">{{ __('Instance administration') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <span class="text-gray-700">{{ __('Account deletion reasons') }}</span>
      </div>
    </div>
  </nav>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      @include('instance.partials.menu')

      <div class="grid grid-cols-12 gap-6">
        <!-- content -->
        <div class="col-span-12">
          <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-4 py-3">
              <h2 class="text-base font-semibold text-gray-900">
                {{ __('Account deletion reasons') }}
              </h2>
            </div>

            @forelse ($cancellationReasons as $reason)
              <div class="border-b border-gray-200 p-4 last:border-b-0">
                <div class="flex flex-col gap-2">
                  <div class="text-sm text-gray-900">
                    {{ $reason->reason }}
                  </div>
                  <div class="text-xs text-gray-500">
                    {{ $reason->created_at->format('Y-m-d H:i:s') }}
                  </div>
                </div>
              </div>
            @empty
              <div class="flex items-center justify-center p-6 text-sm text-gray-500">
                {{ __('No deletion reasons found') }}
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
