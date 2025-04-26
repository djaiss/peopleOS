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

        @include('persons.settings.partials.information', ['person' => $person, 'genders' => $genders])

        @include('persons.settings.partials.age', ['person' => $person])

        @include('persons.settings.partials.avatar', ['person' => $person])

        @include('persons.settings.partials.destroy-person', ['person' => $person])
      </div>
    </div>
  </div>
</x-app-layout>
