<?php
/*
 * @var int $all_count
 * @var int $waiting_count
 * @var int $invited_count
 * @var int $approved_count
 * @var int $rejected_count
 */
?>

<div class="col-span-3">
  <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 px-4 py-3">
      <h2 class="text-base font-semibold text-gray-900">{{ __('Waitlist') }}</h2>
    </div>
    <div class="p-4">
      <div class="space-y-1">
        <a href="{{ route('instance.waitlist.all') }}" class="{{ request()->routeIs('instance.waitlist.all') ? 'bg-gray-50 text-gray-900' : 'text-gray-500' }} flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-50">
          <x-lucide-users class="h-4 w-4" />
          {{ __('All') }}
          <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $all_count ?? 15 }}</span>
        </a>
        <a href="{{ route('instance.waitlist.not-confirmed') }}" class="{{ request()->routeIs('instance.waitlist.not-confirmed') ? 'bg-gray-50 text-gray-900' : 'text-gray-500' }} flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-50">
          <x-lucide-clock class="h-4 w-4" />
          {{ __('Subscribed but not confirmed') }}
          <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $subscribed_not_confirmed_count ?? 10 }}</span>
        </a>
        <a href="{{ route('instance.waitlist.confirmed') }}" class="{{ request()->routeIs('instance.waitlist.confirmed') ? 'bg-gray-50 text-gray-900' : 'text-gray-500' }} flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-50">
          <x-lucide-mail class="h-4 w-4" />
          {{ __('Subscribed and confirmed') }}
          <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $subscribed_and_confirmed_count ?? 5 }}</span>
        </a>
        <a href="{{ route('instance.waitlist.approved') }}" class="{{ request()->routeIs('instance.waitlist.approved') ? 'bg-gray-50 text-gray-900' : 'text-gray-500' }} flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-50">
          <x-lucide-check-circle class="h-4 w-4" />
          {{ __('Approved') }}
          <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $approved_count ?? 5 }}</span>
        </a>
        <a href="{{ route('instance.waitlist.rejected') }}" class="{{ request()->routeIs('instance.waitlist.rejected') ? 'bg-gray-50 text-gray-900' : 'text-gray-500' }} flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm hover:bg-gray-50">
          <x-lucide-x-circle class="h-4 w-4" />
          {{ __('Rejected') }}
          <span class="ml-auto rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $rejected_count ?? 5 }}</span>
        </a>
      </div>
    </div>
  </div>
</div>