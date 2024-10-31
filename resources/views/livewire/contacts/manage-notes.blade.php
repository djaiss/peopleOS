<div>
  <!-- add note -->
  <div class="mb-8 rounded-lg border border-gray-200 bg-white px-3 py-3 shadow-md">
    <form wire:submit="store">
      <x-textarea id="body" wire:model="body" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add a note') }}" dusk="note-body"></x-textarea>
      <x-input-error class="mt-2" :messages="$errors->get('body')" />

      <div class="flex justify-between">
        <p class="text-xs text-gray-500">{{ __('We support Markdown\'s syntax.') }}</p>

        <x-button.secondary type="submit" dusk="submit-note">
          {{ __('Add note') }}
        </x-button.secondary>
      </div>
    </form>
  </div>

  @forelse ($notes as $note)
    <div id="note-{{ $note['id'] }}" class="group mb-5 rounded-lg border border-gray-200 bg-white shadow-md hover:bg-slate-50">
      @if ($editedNoteId !== $note['id'])
        <div class="flex justify-between border-b border-gray-200 px-3 py-2 text-xs">
          <div class="flex text-gray-600">
            <!-- date -->
            <p class="flex items-center">
              <x-lucide-calendar class="mr-1 h-3 w-3" />
              <x-tooltip text="{{ $note['created_at_full_timestamp'] }}" class="mr-2 font-normal">{{ $note['created_at'] }}</x-tooltip>
            </p>
            <p class="ml-3 flex items-center">
              <x-lucide-square-user class="mr-1 h-3 w-3" />
              {{ $note['user']['name'] }}
            </p>
          </div>

          <div>
            <x-link wire:click="editMode({{ $note['id'] }})" class="mr-2 hidden cursor-pointer group-hover:inline" dusk="edit-cta-note-{{ $note['id'] }}">{{ __('Edit') }}</x-link>
            <x-link wire:click="delete({{ $note['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="hidden cursor-pointer group-hover:inline" dusk="delete-note-{{ $note['id'] }}">{{ __('Delete') }}</x-link>
          </div>
        </div>

        <!-- body -->
        <div dusk="note-body-{{ $note['id'] }}" class="px-3 py-2">
          {!! $note['body'] !!}
        </div>

        <!-- edit form -->
      @else
        <div class="px-3 py-3">
          <form wire:submit="update({{ $note['id'] }})">
            <x-textarea wire:model="editedBody" class="mb-2 w-full" rows="3" required placeholder="{{ __('Add a note') }}" dusk="update-note-body-{{ $note['id'] }}">{{ $note['body_raw'] }}</x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('editedBody')" />

            <div class="flex justify-between">
              <p class="text-xs text-gray-500">{{ __('We support Markdown\'s syntax.') }}</p>

              <div class="flex">
                <x-button.secondary wire:click="resetEdit" class="mr-2">
                  {{ __('Cancel') }}
                </x-button.secondary>

                <x-button.primary type="submit" dusk="update-note-{{ $note['id'] }}">
                  {{ __('Save') }}
                </x-button.primary>
              </div>
            </div>
          </form>
        </div>
      @endif
    </div>
  @empty
    <div id="blank-state" class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-6 shadow-md">
      <x-lucide-notebook-pen class="mb-5 h-6 w-6 text-gray-500" />
      <p class="text-center">{{ __('You can add notes to document what you know about this contact.') }}</p>
    </div>
  @endforelse
</div>
