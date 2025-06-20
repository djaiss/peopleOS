<?php
/*
 * @var array $emails_sent
 * @var bool $has_more_emails_sent
 */
?>

<h2 class="font-semi-bold mb-4 text-lg">
  {{ __('Last emails sent') }}
</h2>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- last actions -->
  @forelse ($emails_sent as $emailSent)
    <div x-data="{ open: false, isLast: {{ $loop->last ? 'true' : 'false' }} }">
      <div @click="open = !open" class="group flex cursor-pointer items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg hover:bg-blue-50" :class="{'border-b-0 rounded-b-lg': !open && isLast}">
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

      <div x-cloak x-show="open" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="border-b border-gray-200 bg-gray-50 p-4" :class="{'rounded-b-lg border-b-0': isLast}">
        {!! $emailSent['body'] !!}
      </div>
    </div>
  @empty
    <div class="flex items-center justify-center p-3 text-sm">
      {{ __('No emails sent yet') }}
    </div>
  @endforelse

  @if ($has_more_emails_sent)
    <div class="flex justify-center rounded-b-lg p-3 text-sm hover:bg-blue-50">
      <x-link href="{{ route('administration.emails-sent.index') }}" class="text-center">{{ __('Browse all emails sent') }}</x-link>
    </div>
  @endif
</div>
