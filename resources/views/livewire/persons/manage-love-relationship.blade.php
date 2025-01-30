<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-heart class="h-5 w-5 text-rose-500" />
      <h2 class="text-lg font-semibold text-gray-900">Love & Romance</h2>
    </div>
    <button wire:click="toggleAddMode" type="button" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-2 py-1 text-sm font-medium text-rose-600 hover:bg-rose-100">
      <x-lucide-plus class="h-4 w-4" />
      Add relationship
    </button>
  </div>

  {{-- @if ($addMode) --}}
  <div class="space-y-6 rounded-lg border border-gray-200 bg-white">
    <!-- Tabs -->
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex justify-center space-x-8">
        <button wire:click="$set('addExistingPerson', true)" class="{{ $addExistingPerson ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} cursor-pointer border-b-2 px-1 py-3 text-sm font-medium whitespace-nowrap">
          {{ __('Add existing contact') }}
        </button>
        <button wire:click="$set('addExistingPerson', false)" class="{{ ! $addExistingPerson ? 'border-rose-500 text-rose-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} cursor-pointer border-b-2 px-1 py-3 text-sm font-medium whitespace-nowrap">
          {{ __('Create new contact') }}
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
      <form wire:submit="store">
        <div class="mb-4 flex gap-4 px-4 pt-4">
          <div class="flex-1">
            <x-input-label for="title" :value="__('First name')" class="mb-1" />
            <x-text-input class="block w-full" id="title" name="title" wire:model="title" type="text" data-1p-ignore />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
          </div>
          <div class="flex-1">
            <x-input-label optional for="company" :value="__('Last name')" class="mb-1" />
            <x-text-input class="block w-full" id="company" name="company" wire:model="company" type="text" data-1p-ignore />
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
          </div>
        </div>

        <div class="mb-4 flex gap-4 px-4">
          <div class="flex-1">
            <x-input-label for="duration" :value="__('Nature of relationship')" class="mb-1" />
            <x-text-input class="block w-full" id="duration" placeholder="{{ __('Ex: Spouse, Girlfriend, Boyfriend, etc.') }}" name="duration" wire:model="duration" type="text" data-1p-ignore />
            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
          </div>
          <div class="flex-1">
            <x-input-label optional for="salary" :value="__('Estimated salary')" class="mb-1" />
            <x-text-input class="block w-full" id="salary" name="salary" wire:model="salary" type="text" data-1p-ignore />
            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
          </div>
        </div>

        <div class="mb-4 flex gap-2 border-b border-gray-200 px-4 pb-4">
          <div class="flex h-6 shrink-0 items-center">
            <div class="group grid size-4 grid-cols-1">
              <input id="isCurrentJob" name="isCurrentJob" type="checkbox" wire:model="isCurrentJob" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
              <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </div>
          </div>
          <div class="text-sm/6">
            <label for="isCurrentJob" class="font-medium text-gray-900">{{ __('Create an entry for this person in the contact list') }}</label>
            <p id="isCurrentJob-description" class="text-gray-500">{{ __('If you do, this person will have a dedicated entry.') }}</p>
          </div>
        </div>

        <div class="flex items-center justify-between px-4 pb-4">
          <x-button.secondary wire:click="toggleAddMode" type="button" class="mr-2">
            {{ __('Cancel') }}
          </x-button.secondary>

          <x-button.primary>
            {{ __('Save') }}
          </x-button.primary>
        </div>
      </form>
    @endif
  </div>
  {{-- @endif --}}

  @if ($currentPartners->isEmpty() && $pastPartners->isEmpty())
    <div class="rounded-lg border border-gray-200 bg-white">
      <div class="flex flex-col items-center justify-center p-8 text-center">
        <!-- Decorative heart icon -->
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
          <x-lucide-heart class="h-6 w-6 text-rose-600" />
        </div>

        <!-- Text content -->
        <h3 class="mt-4 text-sm font-semibold text-gray-900">No relationships recorded</h3>
        <p class="mt-1 text-sm text-gray-500">Keep track of romantic relationships, past and present.</p>

        <!-- Call to action -->
        <div class="mt-6">
          <button type="button" class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-100">
            <x-lucide-plus class="h-4 w-4" />
            Add first relationship
          </button>
        </div>
      </div>
    </div>
  @else
    <div class="space-y-4">
      <!-- Current Spouse -->
      <div class="rounded-lg border border-gray-200 bg-white">
        <h3 class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
          <div class="flex items-center gap-2">
            <x-lucide-gem class="h-4 w-4 text-rose-500" />
            Current Relationship
          </div>
        </h3>
        <div class="p-4">
          <div class="flex items-center gap-3">
            <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u=1" alt="" />
            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-1">
                <p class="truncate font-medium text-gray-900">Monica Geller</p>
                {!! getRelationshipIndicator('Monica Geller') !!}
              </div>
              <p class="text-sm text-gray-500">Spouse • 32 years old • Born April 22, 1969</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Past Relationships -->
      <div class="rounded-lg border border-gray-200 bg-white">
        <h3 class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
          <div class="flex items-center gap-2">
            <x-lucide-heart-crack class="h-4 w-4 text-gray-500" />
            Past Relationships
          </div>
        </h3>
        <div class="divide-y divide-gray-200">
          @foreach ([['name' => 'Janice Hosenstein', 'type' => 'Ex-girlfriend', 'birthdate' => 'December 5, 1967'], ['name' => 'Rachel Green', 'type' => 'Ex-girlfriend', 'birthdate' => 'May 5, 1969']] as $relation)
            <div class="p-4">
              <div class="flex items-center gap-3">
                <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $loop->iteration + 10 }}" alt="" />
                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-1">
                    <p class="truncate font-medium text-gray-900">{{ $relation['name'] }}</p>
                    {!! getRelationshipIndicator($relation['name']) !!}
                  </div>
                  <p class="text-sm text-gray-500">{{ $relation['type'] }} • Born {{ $relation['birthdate'] }}</p>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif
</section>
