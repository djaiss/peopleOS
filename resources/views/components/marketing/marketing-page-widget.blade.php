<?php
/*
 * Data come from the MarketingPageWidget component
 */
?>

<div class="flex flex-col justify-between rounded-lg border text-sm">
  <!-- buttons to vote -->
  @if (is_null($findHelpful) && ! session('hasVoted'))
    <div id="thanks" class="relative" x-data="{ showTooltip: false }" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
      <div class="mb-2 flex flex-col items-center justify-center gap-y-4 border-b border-gray-200 p-4 pb-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
        <form x-target="thanks" action="{{ route('marketing.vote-helpful', ['page' => $marketingPage->id]) }}" method="POST">
          @csrf
          <button type="submit" @disabled(! Auth::check()) class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:border-green-700 hover:bg-white">
            <x-lucide-thumbs-up class="h-4 w-4 transform text-green-600 transition-transform group-hover:-rotate-12 group-hover:text-green-700" />
            <span class="text-sm text-gray-700 group-hover:text-gray-900">
              {{ __('This page is helpful') }}
            </span>
          </button>
        </form>
        <form x-target="thanks" action="{{ route('marketing.vote-unhelpful', ['page' => $marketingPage->id]) }}" method="POST">
          @csrf
          <button type="submit" @disabled(! Auth::check()) class="group inline-flex items-center gap-x-2 rounded-sm border border-b-3 border-gray-400 px-3 py-2 transition-colors duration-150 hover:border-red-700 hover:bg-white">
            <x-lucide-thumbs-down class="h-4 w-4 transform text-red-600 transition-transform group-hover:rotate-12 group-hover:text-red-700" />
            <span class="text-sm text-gray-700 group-hover:text-gray-900">
              {{ __('This page is not helpful') }}
            </span>
          </button>
        </form>
      </div>

      @if (! Auth::check())
        <div x-cloak x-show="showTooltip" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="translate-y-1 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-1 opacity-0" class="absolute top-full left-1/2 z-50 mt-0 flex w-96 -translate-x-1/2 items-center gap-x-3 rounded-lg bg-white p-4 shadow-lg ring-1 ring-black/5">
          <img src="{{ asset('marketing/taylor.webp') }}" srcset="{{ asset('marketing/taylor@2x.webp') }} 2x" alt="Taylor Swift being happy" height="80" width="80" loading="lazy" />
          <div class="flex flex-col">
            <p class="text-sm text-gray-600">Please login to vote.</p>
            <p class="text-sm text-gray-600">It's free and will help us improve the page.</p>
            <p class="text-sm font-semibold text-gray-600">Taylor will be proud of you.</p>
          </div>
        </div>
      @endif
    </div>
  @endif

  <!-- thanks message -->
  @if (session('hasVoted'))
    <div id="thanks" class="flex items-center justify-center gap-x-8 border-b border-gray-200 p-4 pb-4">
      <img src="{{ asset('marketing/obama.webp') }}" srcset="{{ asset('marketing/obama@2x.webp') }} 2x" alt="Obama agreeing with you" height="100" width="100" loading="lazy" />

      <div class="flex flex-col gap-y-2">
        <p class="font-semibold">{{ __('Thanks for your feedback!') }}</p>
        <p>{{ __('We will use your feedback to improve this page.') }}</p>
        <p><a href="" class="text-blue-500 hover:underline">{{ __('Care to add a comment?') }}</a></p>
      </div>
    </div>
  @endif

  @if (Auth::check() && ! is_null($findHelpful))
    <div id="thanks" class="flex items-center justify-between gap-x-8 border-b border-gray-200 p-4 pb-4">
      <p>
        You've marked this page as
        <span class="font-semibold">{{ $findHelpful ? 'helpful' : 'not helpful' }}</span>
        on {{ $votedAt }}.
      </p>

      <form x-target="thanks" action="{{ route('marketing.destroy-vote', ['page' => $marketingPage->id]) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="cursor-pointer text-blue-500 hover:underline">{{ __('Remove vote') }}</button>
      </form>
    </div>
  @endif

  <div class="flex items-center justify-between gap-x-4 p-4">
    <p class="mb-1 flex items-center gap-x-1">
      <x-lucide-calendar class="h-4 w-4 text-gray-500" />
      <span class="text-gray-500">Last updated on</span>
      {{ $lastModified }}.
    </p>

    <div class="flex items-center gap-x-2">
      <x-lucide-github class="h-4 w-4 text-gray-500" />
      <a href="https://github.com/djaiss/peopleos" class="text-blue-500 hover:underline">{{ __('Edit this page on Github') }}</a>
    </div>
  </div>
</div>
