<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-heart class="h-5 w-5 text-rose-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Love & romance') }}</h2>
    </div>
    @if (! $addMode)
      <button wire:click="toggleAddMode" type="button" class="inline-flex cursor-pointer items-center gap-1 rounded-md border border-transparent bg-rose-50 px-2 py-1 text-sm font-medium text-rose-600 hover:border hover:border-rose-300 hover:bg-rose-100 hover:text-rose-600">
        <x-lucide-plus class="h-4 w-4" />
        {{ __('Add relationship') }}
      </button>
    @endif
  </div>

  @if ($addMode)
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
              <x-text-input class="block w-full" id="firstName" name="firstName" wire:model="firstName" type="text" required data-1p-ignore />
              <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
            </div>
            <div class="flex-1">
              <x-input-label optional for="lastName" :value="__('Last name')" class="mb-1" />
              <x-text-input class="block w-full" id="lastName" name="lastName" wire:model="lastName" type="text" data-1p-ignore />
              <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
            </div>
          </div>

          <div class="mb-4 flex gap-4 px-4">
            <div class="flex-1">
              <x-input-label for="natureOfRelationship" :value="__('Nature of relationship')" class="mb-1" />
              <x-text-input class="block w-full" id="natureOfRelationship" placeholder="{{ __('Ex: Spouse, Girlfriend, Boyfriend, etc.') }}" wire:model="natureOfRelationship" type="text" required data-1p-ignore />
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
  @endif

  @if ($currentRelationships->isEmpty() && $pastRelationships->isEmpty())
    <div class="rounded-lg border border-gray-200 bg-white">
      <div class="flex flex-col items-center justify-center p-8 text-center">
        <!-- Decorative heart icon -->
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
          <x-lucide-heart class="h-6 w-6 text-rose-600" />
        </div>

        <!-- Text content -->
        <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('No relationships recorded') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of romantic relationships, past and present.') }}</p>

        <!-- Call to action -->
        <div class="mt-6">
          <button wire:click="toggleAddMode" type="button" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-100">
            <x-lucide-plus class="h-4 w-4" />
            {{ __('Add first relationship') }}
          </button>
        </div>
      </div>
    </div>
  @else
    <div class="space-y-4">
      @if ($currentRelationships->isNotEmpty())
        <!-- Current relationships -->
        <div class="rounded-lg border border-gray-200">
          <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
            <div class="flex items-center gap-2">
              <x-lucide-gem class="h-4 w-4 text-rose-500" />
              {{ __('Current relationships') }}
            </div>
          </h3>
          <div class="divide-y divide-gray-200 rounded-b-lg bg-white">
            @foreach ($currentRelationships as $relationship)
              <div wire:key="{{ $relationship['id'] }}" class="p-4 last:rounded-b-lg" x-data="{
                isNew:
                  {{ isset($relationship['is_new']) && $relationship['is_new'] ? 'true' : 'false' }},
              }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
                <div class="flex items-center gap-3">
                  <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $relationship['person']['id'] }}" alt="" />
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1">
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }} •</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Past Relationships -->
      @if ($pastRelationships->isNotEmpty())
        <div class="rounded-lg border border-gray-200">
          <h3 class="rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
            <div class="flex items-center gap-2">
              <x-lucide-heart-crack class="h-4 w-4 text-gray-500" />
              {{ __('Past relationships') }}
            </div>
          </h3>
          <div class="divide-y divide-gray-200 rounded-b-lg bg-white">
            @foreach ($pastRelationships as $relationship)
              <div wire:key="{{ $relationship['id'] }}" class="p-4 last:rounded-b-lg" x-data="{
                isNew:
                  {{ isset($relationship['is_new']) && $relationship['is_new'] ? 'true' : 'false' }},
              }" x-init="isNew && setTimeout(() => (isNew = false), 3000)" :class="{ 'bg-yellow-50 transition-colors duration-1000': isNew }">
                <div class="flex items-center gap-3">
                  <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $relationship['person']['id'] }}" alt="" />
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1">
                      <p class="truncate font-medium text-gray-900">{{ $relationship['person']['name'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500">{{ $relationship['type'] }} •</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  @endif
</section>
