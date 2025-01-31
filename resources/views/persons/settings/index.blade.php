<?php
/*
 * @var Collection $persons
 * @var \App\Models\Person $person
 * @var Collection $genders
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
      <div class="mx-auto max-w-2xl p-6">
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Manage person') }}
        </h1>

        <h2 class="font-semi-bold mb-1 text-lg">
          {{ __('Edit person') }}
        </h2>

        <p class="mb-4 text-sm text-zinc-500">
          {{ __('Edit the person details here.') }}
        </p>

        <livewire:persons.manage-names :genders="$genders" :person="$person" />

        <h2 class="font-semi-bold mb-1 text-lg">
          {{ __('Delete person') }}
        </h2>

        <p class="mb-4 text-sm text-zinc-500">
          {{ __('All the data related to this person will be deleted. Please be certain.') }}
        </p>

        <!--  -->
        <div class="mb-6 rounded-lg border border-gray-200 bg-white">
          <form action="{{ route('persons.settings.destroy', ['slug' => $person->slug]) }}" method="post">
            @csrf
            @method('delete')

            <div class="flex items-center justify-center gap-x-3 px-3 py-3">
              <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this person? This action cannot be undone.') }}')" class="inline-flex items-center gap-x-2 rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                <x-lucide-trash-2 class="h-4 w-4" />
                {{ __('Delete person') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
