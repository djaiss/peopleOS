<?php
/*
 * @var Collecton $pending_testimonials
 * @var int $approved_testimonials_count
 * @var int $rejected_testimonials_count
 * @var int $all_testimonials_count
 */
?>

<x-app-layout>
  <!-- Admin Panel Indicator -->
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
        <span class="text-gray-700">{{ __('Testimonials panel') }}</span>
      </div>
    </div>
  </nav>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="grid grid-cols-2">
        <!-- menu -->
        <div>
          <div>
            <a href="">Pending testimonials ({{ count($pending_testimonials) }})</a>
          </div>
          <div>
            <a href="">Approved testimonials ({{ $approved_testimonials_count }})</a>
          </div>
          <div>
            <a href="">Rejected testimonials ({{ $rejected_testimonials_count }})</a>
          </div>
          <div>
            <a href="">All testimonials ({{ $all_testimonials_count }})</a>
          </div>
        </div>

        <!-- content -->
        <div>
        @forelse ($pending_testimonials as $testimonial)
        <div x-data="{ open: false }">
          <div @click="open = !open" class="group flex cursor-pointer items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg hover:bg-blue-50" :class="{'border-b-0 rounded-b-lg': !open && $loop->last}">
            <div class="flex flex-col gap-1">
              <div>
                <span class="font-light text-gray-500">{{ __('From:') }}</span>
                {{ $testimonial['name_to_display'] }}
              </div>
              <div>
                <span class="font-light text-gray-500">{{ __('Real name:') }}</span>
                {{ $testimonial['user']['name'] }}
              </div>
            </div>

            <div class="flex items-center gap-x-3">
              <!-- sent at && delivered at -->
              <div class="flex flex-col gap-1">
                <div>
                  <span class="font-light text-gray-500">{{ __('Written at:') }}</span>
                  {{ $testimonial['created_at'] }}
                </div>
              </div>

              <!-- arrow -->
              <x-lucide-chevron-down x-show="!open" class="h-4 w-4 text-gray-500 transition-transform duration-200" />
              <x-lucide-chevron-up x-show="open" class="h-4 w-4 text-gray-500 transition-transform duration-200" />
            </div>
          </div>

          <div x-cloak x-show="open" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="border-b border-gray-200 bg-gray-50 p-4" :class="{'rounded-b-lg border-b-0': $loop->last}">
            {{ $testimonial['testimony'] }}
          </div>
        </div>
      @empty
        <div class="flex items-center justify-center p-3 text-sm">
          {{ __('No testimonials pending yet') }}
        </div>
      @endforelse
      </div>

      </div>
    </div>
  </div>
</x-app-layout>
