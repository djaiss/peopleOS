<?php
/*
 * @var Collection $persons
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px,320px,1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.contact-list', ['persons' => $persons])

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="p-6">
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">Contact History</h2>
          </div>
          <div class="divide-y divide-gray-200">
            @foreach (range(1, 50) as $i)
              <div class="flex items-center justify-between p-4">
                <div class="flex items-center gap-3">
                  @php
                    $actions = [
                      ['icon' => 'gift', 'color' => 'text-purple-500', 'text' => 'Added a gift idea: Kindle Paperwhite'],
                      ['icon' => 'heart', 'color' => 'text-rose-500', 'text' => 'Updated relationship status to Married'],
                      ['icon' => 'baby', 'color' => 'text-blue-500', 'text' => 'Added a child: Emma'],
                      ['icon' => 'calendar', 'color' => 'text-green-500', 'text' => 'Scheduled a reminder for birthday'],
                      ['icon' => 'phone', 'color' => 'text-indigo-500', 'text' => 'Had a phone call - discussed work project'],
                      ['icon' => 'mail', 'color' => 'text-amber-500', 'text' => 'Sent a congratulations email'],
                      ['icon' => 'coffee', 'color' => 'text-orange-500', 'text' => 'Met for coffee at Starbucks'],
                      ['icon' => 'cake', 'color' => 'text-pink-500', 'text' => 'Celebrated their 32nd birthday'],
                      ['icon' => 'briefcase', 'color' => 'text-gray-500', 'text' => 'Updated job to Senior Developer at Google'],
                      ['icon' => 'home', 'color' => 'text-teal-500', 'text' => 'Moved to a new house in San Francisco'],
                    ];
                    $action = $actions[array_rand($actions)];
                  @endphp

                  <x-dynamic-component :component="'lucide-' . $action['icon']" class="h-4 w-4 {{ $action['color'] }}" />
                  <div>
                    <p class="text-sm text-gray-900">{{ $action['text'] }}</p>
                    <p class="text-xs text-gray-500">{{ fake()->dateTimeBetween('-1 year')->format('M j, Y') }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
