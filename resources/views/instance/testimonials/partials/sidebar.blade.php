<?php
/*
 * @var int $pending_testimonials_count
 * @var int $approved_testimonials_count
 * @var int $rejected_testimonials_count
 * @var int $all_testimonials_count
 */
?>

<div class="col-span-3">
  <div class="rounded-lg border border-gray-200 bg-white">
    <div class="border-b border-gray-200 px-4 py-3">
      <h2 class="text-base font-semibold text-gray-900">{{ __('Testimonials') }}</h2>
    </div>
    <nav class="p-2">
      <a href="{{ route('instance.testimonial.index') }}" class="group {{ request()->routeIs('instance.testimonial.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }} flex items-center gap-x-3 rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-50">
        <x-lucide-clock class="h-4 w-4 text-gray-400 group-hover:text-gray-500" />
        {{ __('Pending') }}
        <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $pending_testimonials_count }}</span>
      </a>
      <a href="{{ route('instance.testimonial.approved') }}" class="group {{ request()->routeIs('instance.testimonial.approved') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }} flex items-center gap-x-3 rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-50">
        <x-lucide-check-circle class="h-4 w-4 text-gray-400 group-hover:text-gray-500" />
        {{ __('Approved') }}
        <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $approved_testimonials_count }}</span>
      </a>
      <a href="{{ route('instance.testimonial.rejected') }}" class="group {{ request()->routeIs('instance.testimonial.rejected') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }} flex items-center gap-x-3 rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-50">
        <x-lucide-x-circle class="h-4 w-4 text-gray-400 group-hover:text-gray-500" />
        {{ __('Rejected') }}
        <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $rejected_testimonials_count }}</span>
      </a>
      <a href="{{ route('instance.testimonial.all') }}" class="group {{ request()->routeIs('instance.testimonial.all') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }} flex items-center gap-x-3 rounded-md px-3 py-2 text-sm font-medium hover:bg-gray-50">
        <x-lucide-list class="h-4 w-4 text-gray-400 group-hover:text-gray-500" />
        {{ __('All') }}
        <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $all_testimonials_count }}</span>
      </a>
    </nav>
  </div>
</div>
