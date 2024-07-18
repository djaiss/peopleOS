<?php
/**
 * @var \App\Models\Vault $vault
 * @var array $contact
 * @var array $note
 */
?>

<div id="note" x-data="{ editMode: false }" class="group mb-4 border-b border-gray-200 pb-4">
  <div x-show="! editMode">
    <div class="mb-2 flex justify-between text-xs">
      <div class="flex">
        <!-- date -->
        <p>
          <x-tooltip text="{{ $note['created_at_full_timestamp'] }}" class="mr-2 font-bold">{{ $note['created_at'] }}</x-tooltip>
        </p>
        <p class="text-gray-400">{{ __('Note by :user', ['user' => $note['user']['name']]) }}</p>
      </div>

      <x-link x-on:click="editMode = true, $nextTick(() => {$refs.noteBody.focus()})" class="hidden cursor-pointer group-hover:inline">{{ __('Edit') }}</x-link>
    </div>

    <!-- body -->
    <div dusk="note-body-{{ $note['id'] }}">
      {!! $note['body'] !!}
    </div>
  </div>

  <!-- edit form -->
  <div x-cloak x-show="editMode" id="editMode">
    <form hx-target="#note" hx-put="{{ route('vaults.contacts.notes.update', ['vault' => $vault, 'slug' => $contact['slug'], 'note' => $note['id']]) }}" class="mb-4 border-b border-gray-200" hx-on::after-request="this.reset()">
      @csrf
      @method('PUT')

      <x-textarea :xRef="'noteBody'" id="body" name="body" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add a note') }}" dusk="update-note-body">{{ $note['body_raw'] }}</x-textarea>
      <div class="mb-3 flex items-center justify-between">
        <p class="text-xs">{{ __('Show options') }} (change date or add reminder)</p>

        <x-button.secondary type="submit" dusk="update-note">
          {{ __('Save') }}
        </x-button.secondary>
      </div>
    </form>
  </div>
</div>
