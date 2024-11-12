<div>
  <h2 class="mb-2 font-bold">{{ __('Genders') }}</h2>

  <div class="mb-4 flex items-center justify-between">
    <p class="text-sm text-gray-500">{{ __('You can reorder the genders by dragging and dropping.') }}</p>

    @if (! $addMode)
      <x-button.secondary wire:click="toggleAddMode">
        <span>{{ __('New gender') }}</span>
      </x-button.secondary>
    @endif
  </div>

  <div>
    @if ($addMode)
      <form wire:submit="store" class="mb-4 space-y-5 rounded-lg border border-gray-200 p-4">
        <!-- name -->
        <div class="relative">
          <x-input-label for="name" :value="__('Gender name')" />
          <x-text-input wire:model="name" wire:keydown.escape="toggleAddMode" class="mt-1 block w-full" id="name" name="name" type="text" required autofocus />
          <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="flex">
          <x-button.primary class="mr-2">
            {{ __('Save') }}
          </x-button.primary>

          <x-button.secondary wire:click="toggleAddMode">
            {{ __('Cancel') }}
          </x-button.secondary>
        </div>
      </form>
    @endif
  </div>

  <div class="mb-4 rounded-lg border border-gray-200">
    @forelse ($genders as $gender)
      <div class="flex border-b border-b-gray-200 py-2 last:border-b-0 hover:bg-blue-50 first:hover:rounded-t-lg last:hover:rounded-b-lg sm:flex-row sm:items-center sm:justify-between sm:px-3 dark:hover:bg-gray-600">
        @if ($editedGenderId !== $gender['id'])
          <div class="flex items-center">
            <p>{{ $gender['label'] }}</p>
          </div>

          <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen=true" class="inline-flex items-center justify-center rounded-md border bg-white px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 focus:bg-white focus:outline-none active:bg-white disabled:pointer-events-none disabled:opacity-50">
              <span class="mr-2">{{ __('Options') }}</span>
              <x-lucide-chevron-down class="h-4 w-4 text-gray-500" />
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen=false" x-transition:enter="duration-200 ease-out" x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0" class="absolute -top-3 left-1/2 z-50 mt-12 w-56 -translate-x-1/2" x-cloak>
              <div class="mt-1 rounded-md border border-neutral-200/70 bg-white p-1 text-neutral-700 shadow-md">
                <span wire:click="toggleEditMode({{ $gender['id'] }})" class="relative flex cursor-default select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                  <x-lucide-pencil class="mr-2 h-4 w-4 text-gray-600" />
                  <span>{{ __('Edit') }}</span>
                </span>
                <span wire:click="delete({{ $gender['id'] }})" wire:confirm="{{ __('Are you sure you want to proceed? This can not be undone.') }}" class="relative flex cursor-default select-none items-center rounded px-2 py-1.5 text-sm outline-none transition-colors hover:bg-neutral-100 data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                  <x-lucide-trash-2 class="mr-2 h-4 w-4 text-gray-600" />
                  <span>{{ __('Delete') }}</span>
                </span>
              </div>
            </div>
          </div>
        @else
          <form wire:submit="update({{ $gender['id'] }})" class="space-y-5">
            <!-- name -->
            <div class="relative">
              <x-input-label for="name" :value="__('Gender name')" />
              <x-text-input wire:model="editedName" wire:keydown.escape="resetEdit" class="mt-1 block w-full" id="editedName" name="editedName" type="text" required autofocus />
              <x-input-error class="mt-2" :messages="$errors->get('editedName')" />
            </div>

            <div class="flex">
              <x-button.primary class="mr-2">
                {{ __('Save') }}
              </x-button.primary>

              <x-button.secondary wire:click="resetEdit">
                {{ __('Cancel') }}
              </x-button.secondary>
            </div>
          </form>
        @endif
      </div>
    @empty
      <div id="blank-state" class="flex flex-col items-center rounded-lg bg-white p-6">
        <div class="mb-5 rounded-full bg-slate-100 p-4">
          <x-lucide-user class="h-6 w-6 text-gray-500" />
        </div>

        <p class="text-center">{{ __('Genders are used to express the gender of contacts.') }}</p>
      </div>
    @endforelse
  </div>
</div>
