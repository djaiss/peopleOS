<?php
/*
 * @var array $persons
 * @var \App\Models\Person $person
 * @var array $months
 * @var int $total_reminders
 * @var array $tasks
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
          {{ __('Tasks & Reminders') }}
        </h1>

        <!-- tasks -->
        @include(
          'persons.reminders.partials.tasks',
          [
            'person' => $person,
            'activeTasks' => $active_tasks,
            'completedTasks' => $completed_tasks,
          ]
        )

        <!-- reminders -->
        @include(
          'persons.reminders.partials.reminders',
          [
            'person' => $person,
            'months' => $months,
            'total_reminders' => $total_reminders,
          ]
        )
      </div>
    </div>
  </div>
</x-app-layout>
