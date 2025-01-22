<?php
/*
 * @var array $person
 * @var array $persons
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px,320px,1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.contact-list', ['persons' => $persons])

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile', ['person' => $person])

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">contact</div>
  </div>
</x-app-layout>
