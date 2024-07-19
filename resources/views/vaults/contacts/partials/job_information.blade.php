<?php
/**
 * @var array $vault
 * @var array $contact
 */
?>

<div id="job-information" class="mb-2 flex w-full items-start">
  <x-heroicon-o-briefcase class="mr-2 h-4 w-4 flex-shrink-0 text-gray-500" />

  <div class="w-full" x-data="{ editMode: false }">
    <div x-show="! editMode">
      @if ($contact['job_title'] && $contact['company'])
        <span x-on:click="
          (editMode = true),
            $nextTick(() => {
              $refs.backgroundInformation.focus()
            })
        " class="cursor-pointer hover:bg-yellow-300" dusk="job-information">{{ $contact['job_title'] }} ({{ $contact['company'] }})</span>
      @else
        <span x-on:click="
          (editMode = true),
            $nextTick(() => {
              $refs.backgroundInformation.focus()
            })
        " class="cursor-pointer border-b border-dotted border-gray-500 text-gray-500 hover:bg-yellow-300" dusk="blank-job-information">{{ __('Add job information') }}</span>
      @endif
    </div>

    <div x-cloak x-show="editMode">
      <form hx-target="#job-information" hx-swap="outerHTML" hx-put="{{ route('vaults.contacts.background-information.update', ['vault' => $vault, 'slug' => $contact['slug']]) }}" class="mb-4" hx-on::after-request="this.reset()">
        @csrf
        @method('PUT')

        <x-textarea :xRef="'backgroundInformation'" @keyup.escape="editMode = false" id="information" name="information" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add any details about this person') }}" dusk="contact-job-information">{{ $contact['background_information'] }}</x-textarea>
        <div class="flex justify-end">
          <div class="flex items-center">
            <x-button.secondary x-on:click="editMode = false" class="mr-2">
              {{ __('Cancel') }}
            </x-button.secondary>

            <x-button.primary type="submit" dusk="update-job-information">
              {{ __('Save') }}
            </x-button.primary>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
