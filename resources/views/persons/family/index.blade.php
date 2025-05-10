<?php
/*
 * @var Person $person
 * @var Collection $persons
 * @var Collection $currentRelationships
 * @var Collection $pastRelationships
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
        <section class="mb-8">
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <x-lucide-baby class="h-5 w-5 text-blue-500" />
              <h2 class="text-lg font-semibold text-gray-900">Children</h2>
            </div>
            <button type="button" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
              <x-lucide-plus class="h-4 w-4" />
              Add child
            </button>
          </div>
          <div class="rounded-lg border border-gray-200 bg-white">
            <div class="divide-y divide-gray-200">
              @foreach ([['name' => 'Jack Bing', 'type' => 'Son', 'age' => 2, 'birthdate' => 'May 6, 2021'], ['name' => 'Erica Bing', 'type' => 'Daughter', 'age' => 2, 'birthdate' => 'May 6, 2021']] as $child)
                <div class="p-4">
                  <div class="flex items-center gap-3">
                    <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $loop->iteration + 20 }}" alt="" />
                    <div class="min-w-0 flex-1">
                      <div class="flex items-center gap-1">
                        <p class="truncate font-medium text-gray-900">{{ $child['name'] }}</p>
                      </div>
                      <p class="text-sm text-gray-500">{{ $child['type'] }} • {{ $child['age'] }} years old • Born {{ $child['birthdate'] }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </section>

        <!-- Extended family -->
        <section class="mb-8">
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <x-lucide-users class="h-5 w-5 text-indigo-500" />
              <h2 class="text-lg font-semibold text-gray-900">Extended Family</h2>
            </div>
            <button type="button" class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2 py-1 text-sm font-medium text-indigo-600 hover:bg-indigo-100">
              <x-lucide-plus class="h-4 w-4" />
              Add family member
            </button>
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            @php
              $familyGroups = [
                'Parents' => [
                  ['name' => 'Jack Geller', 'type' => 'Father in law', 'birthdate' => 'October 1, 1940'],
                  ['name' => 'Judy Geller', 'type' => 'Mother in law', 'birthdate' => 'February 15, 1942'],
                ],
                'Siblings' => [['name' => 'Ross Geller', 'type' => 'Brother in law', 'birthdate' => 'October 18, 1967']],
                'Other Family' => [
                  ['name' => 'Ben Geller', 'type' => 'Nephew', 'birthdate' => 'May 11, 1995'],
                  ['name' => 'Emma Geller-Green', 'type' => 'Niece', 'birthdate' => 'April 4, 2002'],
                ],
              ];

              $familyIcons = [
                'Parents' => 'person-standing',
                'Siblings' => 'users',
                'Other Family' => 'users-2',
              ];
            @endphp

            @foreach ($familyGroups as $groupName => $relatives)
              <div class="rounded-lg border border-gray-200 bg-white">
                <h3 class="border-b border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700">
                  <div class="flex items-center gap-2">
                    <x-dynamic-component :component="'lucide-' . $familyIcons[$groupName]" class="h-4 w-4 text-gray-500" />
                    {{ $groupName }}
                  </div>
                </h3>
                <div class="divide-y divide-gray-200">
                  @foreach ($relatives as $relative)
                    <div class="p-4">
                      <div class="flex items-center gap-3">
                        <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $loop->parent->iteration * 10 + $loop->iteration }}" alt="" />
                        <div class="min-w-0 flex-1">
                          <div class="flex items-center gap-1">
                            <p class="truncate font-medium text-gray-900">{{ $relative['name'] }}</p>
                          </div>
                          <p class="text-sm text-gray-500">{{ $relative['type'] }} • Born {{ $relative['birthdate'] }}</p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </section>

        <!-- Friends Section -->
        <section>
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <x-lucide-smile class="h-5 w-5 text-amber-500" />
              <h2 class="text-lg font-semibold text-gray-900">Friends & Others</h2>
            </div>
            <button type="button" class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-2 py-1 text-sm font-medium text-amber-600 hover:bg-amber-100">
              <x-lucide-plus class="h-4 w-4" />
              Add friend
            </button>
          </div>
          <div class="rounded-lg border border-gray-200 bg-white">
            <div class="divide-y divide-gray-200">
              @foreach ([['name' => 'Joey Tribbiani', 'type' => 'Best friend', 'birthdate' => 'July 25, 1967'], ['name' => 'Phoebe Buffay', 'type' => 'Close friend', 'birthdate' => 'February 16, 1967'], ['name' => 'Rachel Green', 'type' => 'Best friend', 'birthdate' => 'May 5, 1969']] as $friend)
                <div class="p-4">
                  <div class="flex items-center gap-3">
                    <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $loop->iteration + 50 }}" alt="" />
                    <div class="min-w-0 flex-1">
                      <div class="flex items-center gap-1">
                        <p class="truncate font-medium text-gray-900">{{ $friend['name'] }}</p>
                      </div>
                      <p class="text-sm text-gray-500">{{ $friend['type'] }} • Born {{ $friend['birthdate'] }}</p>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</x-app-layout>
