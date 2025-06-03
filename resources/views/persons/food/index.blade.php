<?php
/*
 * @var array $persons
 * @var \App\Models\Person $person
 * @var \Illuminate\Support\Collection $food_allergies
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
        <!-- Food Allergies Section -->
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Food') }}
        </h1>

        @include('persons.food.partials.allergies.index', ['person' => $person, 'food_allergies' => $food_allergies])
      </div>
    </div>
  </div>
</x-app-layout>
