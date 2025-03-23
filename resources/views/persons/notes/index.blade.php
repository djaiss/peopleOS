<?php
/*
 * @var array $notes
 * @var array $persons
 * @var \App\Models\Person $person
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.persons-list', ['persons' => $persons, 'person' => $person])

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="p-6">
        <!-- Add note form -->
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-4">
          <form id="add-note-form" x-target="notes-list add-note-form" action="{{ route('person.note.create', $person->slug) }}" method="POST">
            @csrf

            <div class="mb-4">
              <x-textarea name="content" required class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none" rows="3" placeholder="{{ __('Write your note here...') }}"></x-textarea>
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
        <div id="notes-list">
          @forelse ($notes as $note)
            <div id="note-{{ $note['id'] }}" class="group mb-4 overflow-hidden rounded-lg border border-gray-200 bg-white transition hover:border-gray-300 hover:shadow-sm">
              <div class="first:rounded-t-lg last:rounded-b-lg">
                <div class="flex items-center justify-between border-b border-gray-200 bg-gray-50/50 px-4 py-2">
                  <!-- note header -->
                  <div class="flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100">
                      <x-lucide-book-open class="h-3 w-3 text-blue-600" />
                    </span>
                    <div>
                      <p class="text-xs text-gray-600">
                        {{ $note['created_at'] }}
                      </p>
                    </div>
                  </div>

                  <!-- note options -->
                  <div x-cloak class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center rounded-md p-1 text-gray-400 opacity-0 group-hover:opacity-100 hover:bg-gray-100 hover:text-gray-600">
                      <x-lucide-more-horizontal class="h-4 w-4" />
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-100 mt-1 w-48 rounded-md border border-gray-200 bg-white py-1 shadow-lg">
                      <a href="{{ route('person.note.edit', ['slug' => $person->slug, 'note' => $note['id']]) }}" x-target="note-{{ $note['id'] }}" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <x-lucide-pencil class="h-4 w-4" />
                        {{ __('Edit') }}
                      </a>

                      <form x-target="note-{{ $note['id'] }}" x-on:ajax:before="
                        confirm('Are you sure you want to proceed? This can not be undone.') ||
                          $event.preventDefault()
                      " action="{{ route('person.note.destroy', ['slug' => $person->slug, 'note' => $note['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                          <x-lucide-trash-2 class="h-4 w-4" />
                          {{ __('Delete') }}
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <p class="whitespace-pre-wrap text-gray-700">{{ $note['content'] }}</p>
                </div>
              </div>
            </div>
          @empty
            <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center">
              <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                <x-lucide-book-open class="h-6 w-6 text-amber-600" />
              </div>
              <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No notes yet') }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                {{ __('Start writing notes about this person to keep track of important details and memories.') }}
              </p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
