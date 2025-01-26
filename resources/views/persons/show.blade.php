<?php
/*
 * @var Person $person
 * @var Collection $persons
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    <livewire:persons.show-person-list :persons="$persons" :person="$person" />

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile', ['person' => $person])

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">contact</div>
  </div>
</x-app-layout>
