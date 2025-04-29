<?php
/*
 * @var Testimony $testimonial
 */
?>

<form id="testimonial-{{ $testimonial->id }}" x-target="testimonial-{{ $testimonial->id }}" action="{{ route('administration.marketing.testimonial.update', $testimonial->id) }}" method="POST" class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  @csrf
  @method('PUT')

  <div class="flex gap-2 px-4 pt-4">
    <div class="">
      <x-input-label for="name" :value="__('Your name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $testimonial->name_to_display) }}" required />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex-1">
      <x-input-label for="url_to_point_to" :value="__('URL to point to when clicking on your name')" :optional="true" />
      <x-text-input id="url_to_point_to" name="url_to_point_to" type="text" class="mt-1 block w-full" value="{{ old('url_to_point_to', $testimonial->url_to_point_to) }}" />
      <x-input-error :messages="$errors->get('url_to_point_to')" class="mt-2" />
    </div>
  </div>

  <div class="border-b border-gray-200 p-4">
    <x-input-label for="testimony" :value="__('Your testimony')" />
    <x-textarea name="testimony" class="mt-1 block w-full" rows="3" placeholder="">{{ old('testimony', $testimonial->testimony) }}</x-textarea>
    <x-input-error :messages="$errors->get('testimony')" class="mt-2" />
  </div>

  <div class="flex items-center justify-between px-4 pt-4 pb-4">
    <x-button.secondary x-target="testimonial-{{ $testimonial->id }}" href="{{ route('administration.marketing.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
