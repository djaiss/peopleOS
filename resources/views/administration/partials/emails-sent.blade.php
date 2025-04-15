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
    <div class="flex group items-center justify-between border-b border-gray-200 p-3 text-sm first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
      <div class="flex items-center gap-x-3">
        @if ($emailSent['sent_at'] && !$emailSent['delivered_at'])
          <span class="animate-pulse top-0 right-0 w-4 h-4 bg-yellow-500 border-2 border-white rounded-full"></span>
        @elseif ($emailSent['delivered_at'] && $emailSent['sent_at'])
          <span class="animate-pulse top-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
        @elseif ($emailSent['bounced_at'])
          <span class="animate-pulse top-0 right-0 w-4 h-4 bg-red-500 border-2 border-white rounded-full"></span>
        @endif

        <div class="flex flex-col gap-1">
          <div><span class="font-light text-gray-500">{{ __('To:') }}</span> {{ $emailSent['email_address'] }}</div>
          <div><span class="font-light text-gray-500">{{ __('Subject:') }}</span> {{ $emailSent['subject'] }}</div>
        </div>
      </div>

      <div class="flex gap-x-3 items-center">
        <!-- sent at && delivered at -->
        <div class="flex flex-col gap-1">
          <div>
            <span class="font-light text-gray-500">{{ __('Sent at:') }}</span> {{ $emailSent['sent_at'] }}
          </div>

          @if ($emailSent['delivered_at'])
            <div><span class="font-light text-gray-500">{{ __('Delivered at:') }}</span> {{ $emailSent['delivered_at'] }}</div>
          @endif
        </div>

        <!-- arrow -->
        <x-lucide-move-right class="w-4 h-4 text-gray-500 group-hover:animate-[bounce_1s_ease-in-out_infinite]" />
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
