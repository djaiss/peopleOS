<?php
/*
 * @var \App\Models\Note $note
 * @var \App\Models\Person $person
 */
?>

<form x-target="note-{{ $note->id }}" id="note-{{ $note->id }}" action="{{ route('person.note.update', ['slug' => $person->slug, 'note' => $note->id]) }}" method="POST" class="mb-4 rounded-lg border border-gray-200 bg-white p-4">
  @csrf
  @method('PUT')

  <div class="mb-4">
    <x-textarea name="content" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-hidden" placeholder="{{ __('Write your note here...') }}">{{ old('content', $note->content) }}</x-textarea>
    <x-input-error class="mt-2" :messages="$errors->get('content')" />
  </div>

  <div class="flex items-center justify-between">
    <x-button.secondary x-target="note-{{ $note->id }}" href="{{ route('person.note.index', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
