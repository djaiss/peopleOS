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
        <!-- <livewire:persons.manage-notes :notes="$notes" :person="$person" /> -->
      </div>
    </div>
  </div>
</x-app-layout>
