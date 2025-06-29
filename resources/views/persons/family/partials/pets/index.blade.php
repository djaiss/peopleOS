<?php
/*
 * @var Person $person
 * @var Collection $pets
 */
?>

<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-dog class="h-5 w-5 text-green-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Pets') }}</h2>
    </div>
    <a x-target="new-pet" href="{{ route('person.pet.new', $person) }}" class="inline-flex items-center gap-1 rounded-md border border-transparent bg-green-50 px-2 py-1 text-sm font-medium text-green-600 hover:border-green-300 hover:bg-green-100">
      <x-lucide-plus class="h-4 w-4" />
      {{ __('Add pet') }}
    </a>
  </div>

  <div id="new-pet"></div>

  <div id="pets-listing" class="rounded-lg border border-gray-200 bg-white">
    <div class="divide-y divide-gray-200">
      @forelse ($pets as $pet)
        <div id="pet-{{ $pet['id'] }}" class="group p-4">
          <div class="group flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-1 border border-transparent py-1 text-sm">
                @if ($pet['name'])
                  <p class="truncate font-medium text-gray-900">{{ $pet['name'] }}</p>
                @else
                  <p class="truncate text-gray-900 italic">{{ __('Unknown name') }}</p>
                @endif
                <span class="text-gray-500">•</span>
                <span class="truncate text-gray-500">{{ ucfirst($pet['species']) }}</span>
                @if ($pet['breed'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ $pet['breed'] }}</span>
                @endif

                @if ($pet['gender'])
                  <span class="text-gray-500">•</span>
                  <span class="truncate text-gray-500">{{ ucfirst($pet['gender']) }}</span>
                @endif
              </div>
            </div>
            <div class="flex items-center gap-2">
              <a x-target="pet-{{ $pet['id'] }}" href="{{ route('person.pet.edit', ['slug' => $person->slug, 'pet' => $pet['id']]) }}" class="hidden text-sm group-hover:block">
                <x-button.invisible>
                  {{ __('Edit') }}
                </x-button.invisible>
              </a>
              <form x-target="current-pet-{{ $pet['id'] }} pets-listing pets-status" x-on:ajax:before="
                confirm('Are you sure you want to proceed? This can not be undone.') ||
                  $event.preventDefault()
              " action="{{ route('person.pet.destroy', ['slug' => $person->slug, 'pet' => $pet['id']]) }}" method="POST">
                @csrf
                @method('DELETE')

                <x-button.invisible class="hidden text-sm group-hover:block">
                  {{ __('Delete') }}
                </x-button.invisible>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="flex flex-col items-center justify-center p-8 text-center">
          <!-- Decorative pet icon -->
          <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
            <x-lucide-dog class="h-6 w-6 text-green-600" />
          </div>

          <!-- Text content -->
          <h3 class="mt-4 text-sm font-semibold text-gray-900">{{ __('No pets recorded') }}</h3>
          <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of pets, past and present.') }}</p>

          <!-- Call to action -->
          <div class="mt-6">
            <a x-target="new-pet" href="{{ route('person.pet.new', $person) }}" class="inline-flex items-center gap-1 rounded-md bg-green-50 px-3 py-2 text-sm font-medium text-green-600 hover:bg-green-100">
              <x-lucide-plus class="h-4 w-4" />
              {{ __('Add first pet') }}
            </a>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
