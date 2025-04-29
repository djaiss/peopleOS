<?php
/*
 * @var Collection $testimonials
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">{{ __('Your testimonial') }}</h2>
<p class="mb-4 text-sm text-zinc-500">{{ __('Love PeopleOS? We’d be thrilled if you could write a testimonial for us. It will appear on our marketing site, and you have full control over what information is displayed. You can also remove the testimonial at any time. Please note that all testimonials are reviewed before being published online.') }}</p>

<div id="testimonial-list">
  @forelse ($testimonials as $testimonial)
    <div id="testimonial-{{ $testimonial['id'] }}" class="mb-8 border border-gray-200 bg-white p-4 sm:rounded-lg">
      <div class="group mb-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="rounded-full bg-indigo-50 p-2">
            <x-lucide-hand-metal class="h-4 w-4 text-indigo-600" />
          </div>
          <div>
            <p class="text-sm text-gray-500">{{ __('Testimony written on :date', ['date' => $testimonial['created_at']]) }}</p>
          </div>
        </div>

        <!-- actions -->
        <div class="flex gap-2">
          <x-button.invisible x-target="testimonial-{{ $testimonial['id'] }}" href="{{ route('administration.marketing.testimonial.edit', $testimonial['id']) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <form x-target="testimonial-list" x-on:ajax:before="
            confirm('Are you sure you want to proceed? This can not be undone.') ||
              $event.preventDefault()
          " action="{{ route('administration.marketing.testimonial.destroy', $testimonial['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <x-button.invisible class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </form>
        </div>
      </div>

      <!-- testimonial -->
      <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm">
        <div class="mb-2">{{ $testimonial['testimony'] }}</div>

        <!-- who wrote it -->
        <div class="text-sm text-gray-500">
          {{ __('By :name', ['name' => $testimonial['name_to_display']]) }}
          @if ($testimonial['url_to_point_to'])
            -
            <a href="{{ $testimonial['url_to_point_to'] }}" target="_blank">)- {{ $testimonial['url_to_point_to'] }}</a>
          @endif
        </div>

        <!-- status -->
        <div class="text-sm text-gray-500">{{ __('Status: :status', ['status' => $testimonial['status']]) }}</div>
      </div>
    </div>
  @empty
    <div id="new-testimonial" class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
      <div class="flex flex-col items-center justify-center p-6 text-center">
        <div class="mb-3 rounded-full bg-gray-100 p-3">
          <x-lucide-hand-metal class="h-6 w-6 text-gray-400" />
        </div>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No testimonial yet') }}</h3>
        <p class="mt-1 mb-4 text-sm text-gray-500">{{ __('If you like this software, it would be awesome to write a testimony. It can be completely anonymous if you want.') }}</p>

        <a x-target="new-testimonial" href="{{ route('administration.marketing.testimonial.new') }}" class="mr-2 inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-white px-3 py-1 text-center text-sm font-semibold text-gray-700 transition duration-150 ease-in-out hover:bg-gray-50 hover:shadow-xs focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden disabled:opacity-25">{{ __('Write a testimonial') }}</a>
      </div>
    </div>
  @endforelse
</div>
