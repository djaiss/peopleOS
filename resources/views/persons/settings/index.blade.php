<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px,320px,1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.contact-list')

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="p-6">
        <!-- Add Note Section -->
        <div class="mb-6 rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Add a note') }}</h2>
          </div>
          <div class="p-4">
            <form wire:submit="store">
              <div class="mb-4">
                <textarea wire:model="content" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" rows="3" placeholder="{{ __('Write your note here...') }}"></textarea>
              </div>

              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <!-- Emotion Selector -->
                  <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
                      <x-lucide-smile class="h-4 w-4 text-gray-500" />
                      <span>{{ __('Emotion') }}</span>
                    </button>
                  </div>

                  <!-- Reminder -->
                  <button type="button" class="flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">
                    <x-lucide-bell class="h-4 w-4 text-gray-500" />
                    <span>{{ __('Set reminder') }}</span>
                  </button>
                </div>

                <x-button.primary>
                  {{ __('Save') }}
                </x-button.primary>
              </div>
            </form>
          </div>
        </div>

        <!-- Notes List -->
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Notes') }}</h2>
          </div>

          <div class="divide-y divide-gray-200">
            @foreach (range(1, 10) as $i)
              <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    @if (rand(0, 1))
                      @php
                        $emotions = [
                          ['color' => 'yellow', 'icon' => 'smile'],
                          ['color' => 'red', 'icon' => 'heart'],
                          ['color' => 'blue', 'icon' => 'coffee'],
                          ['color' => 'green', 'icon' => 'party-popper'],
                        ];
                        $emotion = $emotions[array_rand($emotions)];
                      @endphp

                      <span class="bg-{{ $emotion['color'] }}-100 flex h-8 w-8 items-center justify-center rounded-full">
                        <x-dynamic-component :component="'lucide-'.$emotion['icon']" class="h-4 w-4 text-{{ $emotion['color'] }}-600" />
                      </span>
                    @endif

                    <p class="text-sm text-gray-600">
                      {{ fake()->dateTimeBetween('-1 year')->format('M j, Y') }}
                    </p>
                  </div>
                  @if (rand(0, 1))
                    <div class="flex items-center gap-1 rounded-full bg-blue-100 px-2 py-1">
                      <x-lucide-bell class="h-3 w-3 text-blue-600" />
                      <span class="text-xs text-blue-600">
                        {{ fake()->dateTimeBetween('now', '+1 year')->format('M j, Y') }}
                      </span>
                    </div>
                  @endif
                </div>
                <p class="text-gray-700">
                  {{
                    collect([
                      "Had coffee with Ross at Central Perk. He's still going on about his divorce with Carol.",
                      'Monica made her famous lasagna for dinner. Joey ate most of it, as usual.',
                      "Phoebe performed 'Smelly Cat' at the coffee house today. The crowd loved it!",
                      "Chandler's sarcasm is getting worse. His new job must be really stressing him out.",
                      'Rachel finally got her dream job at Ralph Lauren. So proud of her!',
                      'Joey got a callback for Days of Our Lives. Dr. Drake Ramoray might be coming back!',
                      'Ross gave another boring lecture about dinosaurs. Only Monica pretended to listen.',
                      'Helped Rachel organize her closet. Found the receipt for that hideous cat.',
                      "Watched Marcel do his monkey business. Ross needs to stop playing 'The Lion Sleeps Tonight'.",
                      'Gunther still pining after Rachel. Some things never change.',
                    ])->random()
                  }}
                </p>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
