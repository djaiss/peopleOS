<div>
  <h2 class="font-semi-bold mb-1 text-lg">
    {{ __('Add a note') }}
  </h2>

  <p class="mb-4 text-sm text-zinc-500">
    {{ __('Record a note about this person so you can remember important details.') }}
  </p>
  <div class="mb-6 rounded-lg border border-gray-200 bg-white">
    <div class="p-4">
      <form wire:submit="store">
        <div class="mb-4">
          <x-textarea wire:model="content" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" rows="3" placeholder="{{ __('Write your note here...') }}"></x-textarea>
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
  </div>

  <!-- Notes list -->
  <div class="rounded-lg border border-gray-200 bg-white">
    <div class="divide-y divide-gray-200">
      @forelse ($notes as $note)
        <div wire:key="{{ $note['id'] }}" class="group p-4 first:rounded-t-lg last:rounded-b-lg hover:bg-blue-50" x-data="{
          isNew: {{ isset($note['is_new']) && $note['is_new'] ? 'true' : 'false' }},
        }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
          <div class="mb-2 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <p class="text-xs text-gray-600">
                {{ $note['created_at'] }}
              </p>
            </div>
          </div>
          <p class="text-gray-700">
            {{ $note['content'] }}
          </p>
        </div>
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
  </div>
</div>
