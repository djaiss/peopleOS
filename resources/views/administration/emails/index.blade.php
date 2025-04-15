<?php
/*
 * @var \Illuminate\Pagination\CursorPaginator $emails_sent
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
          {{ __('All emails sent in this account') }}
        </h1>

        <div id="emails-container" x-merge="append" class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
          <!-- last actions -->
          @foreach ($emails_sent as $emailSent)
            <div x-data="{ open: false }">
              <div @click="open = !open" class="group flex cursor-pointer items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg hover:bg-blue-50" :class="{'border-b-0 rounded-b-lg': !open && $loop->last}">
                <div class="flex items-center gap-x-3">
                  @if ($emailSent['sent_at'] && ! $emailSent['delivered_at'])
                    <span class="top-0 right-0 h-4 w-4 animate-pulse rounded-full border-2 border-white bg-yellow-500"></span>
                  @elseif ($emailSent['delivered_at'] && $emailSent['sent_at'])
                    <span class="top-0 right-0 h-4 w-4 animate-pulse rounded-full border-2 border-white bg-green-500"></span>
                  @elseif ($emailSent['bounced_at'])
                    <span class="top-0 right-0 h-4 w-4 animate-pulse rounded-full border-2 border-white bg-red-500"></span>
                  @endif

                  <div class="flex flex-col gap-1">
                    <div>
                      <span class="font-light text-gray-500">{{ __('To:') }}</span>
                      {{ $emailSent['email_address'] }}
                    </div>
                    <div>
                      <span class="font-light text-gray-500">{{ __('Subject:') }}</span>
                      {{ $emailSent['subject'] }}
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-x-3">
                  <!-- sent at && delivered at -->
                  <div class="flex flex-col gap-1">
                    <div>
                      <span class="font-light text-gray-500">{{ __('Sent at:') }}</span>
                      {{ $emailSent['sent_at'] }}
                    </div>

                    @if ($emailSent['delivered_at'])
                      <div>
                        <span class="font-light text-gray-500">{{ __('Delivered at:') }}</span>
                        {{ $emailSent['delivered_at'] }}
                      </div>
                    @endif
                  </div>

                  <!-- arrow -->
                  <x-lucide-chevron-down x-show="!open" class="h-4 w-4 text-gray-500 transition-transform duration-200" />
                  <x-lucide-chevron-up x-show="open" class="h-4 w-4 text-gray-500 transition-transform duration-200" />
                </div>
              </div>

              <div x-cloak x-show="open" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="border-b border-gray-200 bg-gray-50 p-4" :class="{'rounded-b-lg border-b-0': $loop->last}">
                {!! $emailSent['body'] !!}
              </div>
            </div>
          @endforeach

          @if ($emails_sent->nextPageUrl())
            <div id="pagination" class="flex justify-center rounded-b-lg p-3 text-sm hover:bg-blue-50">
              <x-link x-target="emails-container pagination" href="{{ $emails_sent->nextPageUrl() }}" class="text-center">{{ __('Load more') }}</x-link>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
