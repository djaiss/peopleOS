<div>
  <h2 class="font-semi-bold mb-1 text-lg">
    {{ __('Add a note') }}
  </h2>

  <p class="mb-4 text-sm text-zinc-500">
    {{ __('Record a note about this person so you can remember important details.') }}
  </p>

  <!-- Add note form -->
  <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
    <form wire:submit="store">
      <div class="mb-4">
        <x-textarea wire:model="content" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none" rows="3" placeholder="{{ __('Write your note here...') }}"></x-textarea>
        <x-input-error class="mt-2" :messages="$errors->get('content')" />
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <!-- Emotion Selector -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
              <x-lucide-smile class="h-4 w-4 text-gray-500" />
              <span>{{ __('Emotion') }}</span>
            </button>
          </div>

          <!-- Reminder -->
          <button type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
            <x-lucide-bell class="h-4 w-4 text-gray-500" />
            <span>{{ __('Set reminder') }}</span>
          </button>
        </div>

        <x-button.primary>
          {{ __('Save') }}
        </x-button.primary>
      </div>
    </form>
  </div>

  <!-- Notes list -->
  @forelse ($notes as $note)
    @if ($note['id'] !== $editedNoteId)
      <div class="mb-4 rounded-lg border border-gray-200 bg-white">
        <div wire:key="{{ $note['id'] }}" class="group first:rounded-t-lg last:rounded-b-lg" x-data="{
          isNew: {{ isset($note['is_new']) && $note['is_new'] ? 'true' : 'false' }},
        }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
          <div class="flex items-center justify-between border-b border-gray-200 p-2">
            <div class="flex items-center gap-3">
              <p class="text-xs text-gray-600">
                {{ $note['created_at'] }}
              </p>
            </div>

            <!-- note options -->
            <div x-cloak class="relative" x-data="{ open: false }">
              <button @click="open = !open" type="button" class="flex items-center rounded-md border p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-600">
                <x-lucide-more-horizontal class="h-4 w-4" />
              </button>

              <!-- Dropdown menu -->
              <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-1 w-48 rounded-md border border-gray-200 bg-white py-1 shadow-lg">
                <button type="button" @click="$wire.edit({{ $note['id'] }})" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                  <x-lucide-pencil class="h-4 w-4" />
                  {{ __('Edit') }}
                </button>

                <button type="button" @click="confirm('{{ __('Are you sure you want to proceed? This can not be undone.') }}') ? $wire.delete({{ $note['id'] }}) : false" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                  <x-lucide-trash-2 class="h-4 w-4" />
                  {{ __('Delete') }}
                </button>
              </div>
            </div>
          </div>
          <p class="p-4 text-gray-700 hover:bg-blue-50">
            {{ $note['content'] }}
          </p>
        </div>
      </div>
    @else
      <div class="mb-4 rounded-lg border border-gray-200 bg-white">
        <form wire:submit="update" class="p-4">
          <div class="mb-4">
            <x-textarea wire:model="editedContent" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-hidden" placeholder="{{ __('Write your note here...') }}"></x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('content')" />
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <!-- Emotion Selector -->
              <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
                  <x-lucide-smile class="h-4 w-4 text-gray-500" />
                  <span>{{ __('Emotion') }}</span>
                </button>
              </div>

              <!-- Reminder -->
              <button type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
                <x-lucide-bell class="h-4 w-4 text-gray-500" />
                <span>{{ __('Set reminder') }}</span>
              </button>
            </div>

            <x-button.primary>
              {{ __('Save') }}
            </x-button.primary>
          </div>
        </form>
      </div>
    @endif
  @empty
    <div class="flex flex-col items-center justify-center p-8 text-center">
      <x-lucide-book-open class="h-12 w-12 text-gray-400" />
      <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No notes yet') }}</h3>
      <p class="mt-1 text-sm text-gray-500">
        {{ __('Start writing notes about this person to keep track of important details and memories.') }}
      </p>
    </div>
  @endforelse
</div>
