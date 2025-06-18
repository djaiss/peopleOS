<?php
/*
 * @var Person $person
 * @var Collection $persons
 * @var Collection $currentRelationships
 * @var Collection $pastRelationships
 * @var Collection $children
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Contact list -->
    @include('persons.partials.persons-list', ['persons' => $persons, 'person' => $person])

    <!-- Contact overview -->
    @include('persons.partials.profile')

    <!-- Detail view -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="mx-auto max-w-3xl p-6">
        <!-- Love relationships -->
        @include(
          'persons.family.partials.love.index',
          [
            'person' => $person,
            'currentRelationships' => $currentRelationships,
            'pastRelationships' => $pastRelationships,
          ]
        )

        <!-- Children -->
        @include(
          'persons.family.partials.children.index',
          [
            'person' => $person,
            'children' => $children,
          ]
        )

        <!-- Pets -->
        @include(
          'persons.family.partials.pets.index',
          [
            'person' => $person,
            'pets' => $pets ?? collect(),
          ]
        )
      </div>
    </div>
  </div>
</x-app-layout>
