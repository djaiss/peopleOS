<form id="new-testimonial" x-target="new-testimonial" action="{{ route('administration.marketing.testimonial.create') }}" method="POST" class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  @csrf

  <div class="flex gap-2 px-4 pt-4">
    <div class="">
      <x-input-label for="name" :value="__('Your name')" />
      <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div class="flex-1">
      <x-input-label for="url_to_point_to" :value="__('URL to point to when clicking on your name')" :optional="true" />
      <x-text-input id="url_to_point_to" name="url_to_point_to" type="text" class="mt-1 block w-full" />
      <x-input-error :messages="$errors->get('url_to_point_to')" class="mt-2" />
    </div>
  </div>

  <div class="border-b border-gray-200 p-4">
    <x-input-label for="testimony" :value="__('Your testimony')" />
    <x-textarea name="testimony" class="mt-1 block w-full" rows="3" placeholder=""></x-textarea>
    <x-input-error :messages="$errors->get('testimony')" class="mt-2" />
  </div>

  <div class="flex items-center justify-between px-4 pt-4 pb-4">
    <x-button.secondary x-target="new-testimonial" href="{{ route('administration.marketing.index') }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
