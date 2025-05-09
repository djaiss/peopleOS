<?php
/*
 * @var Collection $waitlist_entries
 * @var int $subscribed_and_confirmed_count
 * @var int $subscribed_not_confirmed_count
 * @var int $approved_count
 * @var int $rejected_count
 * @var int $all_count
 * @var string $title
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
        <a href="/dashboard" class="hover:text-gray-700">{{ __('Dashboard') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <a href="/instance" class="hover:text-gray-700">{{ __('Instance administration') }}</a>
        <x-lucide-chevron-right class="h-4 w-4" />
        <span class="text-gray-700">{{ __('Waitlist management') }}</span>
      </div>
    </div>
  </nav>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      @include('instance.partials.menu')

      <div id="waitlist-table" class="grid grid-cols-12 gap-6">
        <!-- Sidebar menu -->
        @include(
          'instance.waitlist.partials.sidebar',
          [
            'all_count' => $all_count,
            'subscribed_not_confirmed_count' => $subscribed_not_confirmed_count,
            'subscribed_and_confirmed_count' => $subscribed_and_confirmed_count,
            'approved_count' => $approved_count,
            'rejected_count' => $rejected_count,
          ]
        )

        <!-- Content -->
        <div class="col-span-9">
          <div class="rounded-lg border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 px-4 py-3">
              <h2 class="text-base font-semibold text-gray-900">
                {{ $title }}
              </h2>
            </div>

            <div class="divide-y divide-gray-200">
              @forelse ($waitlist_entries as $entry)
                <div id="waitlist-{{ $entry['id'] }}" class="flex items-center justify-between p-4">
                  <div class="flex flex-col gap-1">
                    <div class="font-medium text-gray-900">{{ $entry['email'] }}</div>
                    <div class="flex gap-x-3">
                      <div class="text-sm text-gray-500">Added on {{ $entry['created_at'] }}</div>

                      @if ($entry['status'] === 'subscribed_and_confirmed')
                        <div class="text-sm text-gray-500">Confirmed on {{ $entry['confirmed_at'] }}</div>
                      @endif
                    </div>
                  </div>

                  @if (request()->routeIs('instance.waitlist.index'))
                  <div class="flex items-center gap-x-3">
                    <div class="flex gap-x-2">
                      <!-- approve button -->
                      <form x-target="waitlist-{{ $entry['id'] }} waitlist-table" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.')" action="{{ route('instance.waitlist.approve', $entry['id']) }}" method="post" class="w-full">
                        @csrf
                        @method('put')

                        <button type="submit" class="cursor-pointer rounded-lg border border-green-200 px-3 py-1.5 text-sm font-medium text-green-600 hover:bg-green-50">
                          {{ __('Invite') }}
                        </button>
                      </form>

                      <!-- reject button -->
                      <form x-target="waitlist-{{ $entry['id'] }} waitlist-table" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.')" action="{{ route('instance.waitlist.reject', $entry['id']) }}" method="post" class="w-full">
                        @csrf
                        @method('put')

                        <button type="submit" class="cursor-pointer rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-50">
                          {{ __('Reject') }}
                        </button>
                      </form>
                    </div>
                  </div>
                  @endif
                </div>
              @empty
                <div class="p-4 text-gray-500">
                  {{ __('No waitlist entries found') }}
                </div>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
