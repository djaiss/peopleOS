<?php
/*
 * @var array $persons
 * @var \App\Models\Person $person
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    <livewire:persons.show-person-list :persons="$persons" :person="$person" />

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="mx-auto max-w-2xl p-6">
        <!-- Work History Section -->
        <h1 class="font-semi-bold mb-4 text-2xl">
          {{ __('Work & Passions') }}
        </h1>

        <livewire:persons.manage-work-history :person="$person" />

        <!-- Passions Section -->
        <h2 class="font-semi-bold mb-1 text-lg">
          {{ __('Passions') }}
        </h2>

        <p class="mb-4 text-sm text-zinc-500">
          {{ __('Record what drives and excites them in life.') }}
        </p>

        <div class="rounded-lg border border-gray-200 bg-white">
          <!-- Add Passion Form -->
          <div class="border-b border-gray-200 p-4">
            <button type="button" class="flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
              <x-lucide-plus class="h-4 w-4" />
              {{ __('Add a passion') }}
            </button>
          </div>

          <!-- Passions List -->
          <div class="divide-y divide-gray-200">
            <div class="flex items-center justify-between p-4">
              <div class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-100">
                  <x-lucide-heart class="h-4 w-4 text-rose-600" />
                </span>
                <div>
                  <h3 class="font-medium">Photography</h3>
                  <p class="text-sm text-gray-600">Landscape and street photography enthusiast since 2015</p>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between p-4">
              <div class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-100">
                  <x-lucide-heart class="h-4 w-4 text-rose-600" />
                </span>
                <div>
                  <h3 class="font-medium">Mountain Climbing</h3>
                  <p class="text-sm text-gray-600">Conquered 5 major peaks in the last 3 years</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
