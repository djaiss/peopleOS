<?php
/**
 * @var \App\Models\Vault $vault
 * @var array $contact
 * @var array $note
 */
?>

<div id="note-{{ $note['id'] }}" x-data="{ editMode: false }" class="group mb-4 border-b border-gray-200 pb-4 hover:bg-slate-50">
  <div x-show="! editMode">
    <div class="mb-2 flex justify-between text-xs">
      <div class="flex">
        <!-- date -->
        <p>
          <x-tooltip text="{{ $note['created_at_full_timestamp'] }}" class="mr-2 font-bold">{{ $note['created_at'] }}</x-tooltip>
        </p>
        <p class="text-gray-400">{{ __('Note by :user', ['user' => $note['user']['name']]) }}</p>
      </div>

      <div>
        <x-link x-on:click="editMode = true, $nextTick(() => {$refs.noteBody.focus()})" class="mr-2 hidden cursor-pointer group-hover:inline" dusk="edit-cta-note-{{ $note['id'] }}">{{ __('Edit') }}</x-link>
        <x-link hx-delete="{{ route('vaults.contacts.notes.destroy', ['vault' => $vault, 'slug' => $contact['slug'], 'note' => $note['id']]) }}" hx-confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" hx-target="#note-{{ $note['id'] }}" hx-swap="delete" class="hidden cursor-pointer group-hover:inline" dusk="delete-note-{{ $note['id'] }}">{{ __('Delete') }}</x-link>
      </div>
    </div>

    <!-- body -->
    <div dusk="note-body-{{ $note['id'] }}">
      {!! $note['body'] !!}
    </div>
  </div>

  <!-- edit form -->
  <div x-cloak x-show="editMode">
    <form hx-target="#note-{{ $note['id'] }}" hx-swap="outerHTML" hx-put="{{ route('vaults.contacts.notes.update', ['vault' => $vault, 'slug' => $contact['slug'], 'note' => $note['id']]) }}" class="" hx-on::after-request="this.reset()">
      @csrf
      @method('PUT')

      <x-textarea :xRef="'noteBody'" @keyup.escape="editMode = false" id="body" name="body" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add a note') }}" dusk="update-note-body-{{ $note['id'] }}">{{ $note['body_raw'] }}</x-textarea>
      <div class="flex items-center justify-between">
        <p class="text-xs text-gray-500">{{ __('Show options') }} (change date or add reminder)</p>

        <div class="flex">
          <x-button.secondary x-on:click="editMode = false" class="mr-2">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary type="submit" dusk="update-note-{{ $note['id'] }}">
            {{ __('Save') }}
          </x-button.primary>
        </div>
      </div>
    </form>
  </div>
</div>
