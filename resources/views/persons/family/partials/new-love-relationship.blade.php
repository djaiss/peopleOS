<div class="mb-8 rounded-lg border border-gray-200 bg-white">
      <!-- Tabs -->
      <div class="mb-4 border-b border-gray-200">
        <nav class="-mb-px flex justify-center space-x-8">
          <button wire:click="$set('addExistingPerson', true)" class="{{ $addExistingPerson ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} cursor-pointer border-b-2 px-1 py-3 text-sm font-medium whitespace-nowrap">
            {{ __('Add existing person') }}
          </button>
          <button wire:click="$set('addExistingPerson', false)" class="{{ ! $addExistingPerson ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} cursor-pointer border-b-2 px-1 py-3 text-sm font-medium whitespace-nowrap">
            {{ __('Add someone new') }}
          </button>
        </nav>
      </div>

      @if ($addExistingPerson)
        <!-- Search existing contact -->
        <div class="space-y-4">
          <div class="relative">
            <x-lucide-search class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-gray-400" />
            <x-text-input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10" placeholder="Search for a contact..." />
          </div>

          @if ($search && $searchResults->isNotEmpty())
            <div class="divide-y divide-gray-200 rounded-md border border-gray-200">
              @foreach ($searchResults as $result)
                <button wire:click="selectPerson({{ $result->id }})" type="button" class="flex w-full items-center gap-3 p-3 text-left hover:bg-gray-50">
                  <img class="h-8 w-8 rounded-full object-cover" src="https://i.pravatar.cc/32?u={{ $result->id }}" alt="" />
                  <div>
                    <div class="font-medium text-gray-900">{{ $result->name }}</div>
                    <div class="text-sm text-gray-500">{{ $result->email }}</div>
                  </div>
                </button>
              @endforeach
            </div>
          @endif
        </div>
      @else
        <!-- Create new contact form -->
        <form wire:submit="storeNewPerson">
          <div class="mb-4 flex gap-4 px-4">
            <div class="flex-1">
              <x-input-label for="firstName" :value="__('First name')" class="mb-1" />
              <x-text-input class="block w-full" id="firstName" name="firstName" wire:model="firstName" type="text" required />
              <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
            </div>
            <div class="flex-1">
              <x-input-label optional for="lastName" :value="__('Last name')" class="mb-1" />
              <x-text-input class="block w-full" id="lastName" name="lastName" wire:model="lastName" type="text" />
              <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
            </div>
          </div>

          <div class="mb-4 flex gap-4 px-4">
            <div class="flex-1">
              <x-input-label for="natureOfRelationship" :value="__('Nature of relationship')" class="mb-1" />
              <x-text-input class="block w-full" id="natureOfRelationship" placeholder="{{ __('Ex: Spouse, Girlfriend, Boyfriend, etc.') }}" wire:model="natureOfRelationship" type="text" required />
              <x-input-error :messages="$errors->get('natureOfRelationship')" class="mt-2" />
            </div>
          </div>

          <div class="mb-4 flex gap-2 px-4">
            <div class="flex h-6 shrink-0 items-center">
              <div class="group grid size-4 grid-cols-1">
                <input id="createEntry" name="createEntry" type="checkbox" wire:model="createEntry" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
              </div>
            </div>
            <div class="text-sm/6">
              <label for="createEntry" class="font-medium text-gray-900">{{ __('Create an entry for this person in the contact list') }}</label>
              <p id="createEntry-description" class="text-gray-500">{{ __('You will be able to add notes, link with other persons, etc...') }}</p>
            </div>
          </div>

          <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
            <div class="flex h-6 shrink-0 items-center">
              <div class="group grid size-4 grid-cols-1">
                <input id="active" name="active" type="checkbox" wire:model="active" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
              </div>
            </div>
            <div class="text-sm/6">
              <label for="active" class="font-medium text-gray-900">{{ __('Mark this relationship as active') }}</label>
              <p id="active-description" class="text-gray-500">{{ __('If you mark this relationship as active, it will be displayed in the current relationships section.') }}</p>
            </div>
          </div>

          <div class="flex items-center justify-between px-4 pb-4">
            <x-button.secondary wire:click="toggleAddMode" type="button" class="mr-2">
              {{ __('Cancel') }}
            </x-button.secondary>

            <x-button.primary>
              {{ __('Create relationship') }}
            </x-button.primary>
          </div>
        </form>
      @endif
    </div>