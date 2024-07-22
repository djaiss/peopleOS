<?php
/**
 * @var array $vault
 * @var array $contact
 */
?>

<div id="job-information" class="mb-2 flex w-full items-center">
  <x-heroicon-o-briefcase class="mr-2 h-4 w-4 flex-shrink-0 text-gray-500" />

  <div class="w-full" x-data="{ editMode: false }">
    <div x-show="! editMode">
      @if ($contact['job_title'] && $contact['company'])
        <span>
          <span x-on:click="
            (editMode = true),
              $nextTick(() => {
                $refs.backgroundInformation.focus()
              })
          " dusk="job-information" class="cursor-pointer hover:bg-yellow-300">{{ $contact['job_title'] }}</span>

          @if ($contact['company']['name'])
            ({{ $contact['company']['name'] }})
          @endif
        </span>
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

        <!-- job title -->
        <div class="relative mb-2">
          <x-input-label for="job_title" :value="__('Job title')" />

          <x-text-input :value="old('job_title', $contact['job_title'])" @keyup.escape="editMode = false" class="mt-1 block w-full" id="job_title" name="job_title" type="text" required autofocus />

          <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
        </div>

        <!-- company -->
        <div class="relative mb-2">
          <x-input-label for="company_name" :value="__('Company name')" />

          <x-text-input :value="old('company_name', $contact['company']['name'])" @keyup.escape="editMode = false" class="mt-1 block w-full" id="company_name" name="company_name" type="text" required autofocus />

          <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
        </div>

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
