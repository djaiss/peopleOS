<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl leading-tight font-semibold text-gray-800 dark:text-gray-200">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <!-- Stats Overview -->
      <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('Total Contacts') }}</p>
              <p class="text-2xl font-semibold">42</p>
            </div>
            <div class="rounded-sm bg-blue-100 p-2">
              <x-lucide-users class="h-5 w-5 text-blue-600" />
            </div>
          </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('Journal Entries') }}</p>
              <p class="text-2xl font-semibold">156</p>
            </div>
            <div class="rounded-sm bg-purple-100 p-2">
              <x-lucide-book-open class="h-5 w-5 text-purple-600" />
            </div>
          </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('Active Reminders') }}</p>
              <p class="text-2xl font-semibold">8</p>
            </div>
            <div class="rounded-sm bg-amber-100 p-2">
              <x-lucide-bell class="h-5 w-5 text-amber-600" />
            </div>
          </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-600">{{ __('This Month\'s Birthdays') }}</p>
              <p class="text-2xl font-semibold">3</p>
            </div>
            <div class="rounded-sm bg-rose-100 p-2">
              <x-lucide-cake class="h-5 w-5 text-rose-600" />
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Recently Viewed Contacts -->
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Recently Viewed') }}</h2>
          </div>
          <div class="divide-y divide-gray-200">
            @foreach ([['name' => 'Monica Geller', 'viewed' => '2 hours ago'], ['name' => 'Chandler Bing', 'viewed' => '5 hours ago'], ['name' => 'Ross Geller', 'viewed' => 'Yesterday'], ['name' => 'Rachel Green', 'viewed' => '2 days ago'], ['name' => 'Joey Tribbiani', 'viewed' => '3 days ago']] as $i => $contact)
              <a href="#" class="flex items-center gap-4 p-4 hover:bg-gray-50">
                <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $i }}" alt="{{ $contact['name'] }}" />
                <div>
                  <p class="font-medium text-gray-900">{{ $contact['name'] }}</p>
                  <p class="text-sm text-gray-500">{{ __('Last viewed') }}: {{ $contact['viewed'] }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Contacts Not Seen Recently -->
        <div class="rounded-lg border border-gray-200 bg-white">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Need Attention') }}</h2>
          </div>
          <div class="divide-y divide-gray-200">
            @foreach ([['name' => 'Phoebe Buffay', 'last_seen' => '3 months ago'], ['name' => 'Gunther', 'last_seen' => '4 months ago'], ['name' => 'Mike Hannigan', 'last_seen' => '5 months ago'], ['name' => 'Carol Willick', 'last_seen' => '6 months ago']] as $i => $contact)
              <div class="flex items-center justify-between p-4">
                <div class="flex items-center gap-4">
                  <img class="h-10 w-10 rounded-full object-cover ring-1 ring-gray-200" src="https://i.pravatar.cc/40?u={{ $i + 10 }}" alt="{{ $contact['name'] }}" />
                  <div>
                    <p class="font-medium text-gray-900">{{ $contact['name'] }}</p>
                    <p class="text-sm text-gray-500">{{ __('Last interaction') }}: {{ $contact['last_seen'] }}</p>
                  </div>
                </div>
                <a href="#" class="rounded-md bg-blue-50 px-3 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">
                  {{ __('Add Note') }}
                </a>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Upcoming Reminders -->
        <div class="rounded-lg border border-gray-200 bg-white lg:col-span-2">
          <div class="border-b border-gray-200 p-4">
            <h2 class="text-lg font-semibold">{{ __('Upcoming Reminders') }}</h2>
          </div>
          <div class="divide-y divide-gray-200">
            @foreach ([['title' => 'Call Monica about her promotion', 'due' => 'Tomorrow', 'person' => 'Monica Geller'], ['title' => 'Send birthday card', 'due' => 'Next week', 'person' => 'Chandler Bing'], ['title' => 'Coffee meetup', 'due' => 'In 2 weeks', 'person' => 'Rachel Green'], ['title' => 'Help with apartment hunting', 'due' => 'Next month', 'person' => 'Joey Tribbiani']] as $reminder)
              <div class="flex items-center justify-between p-4" x-data="{ completed: false }">
                <div class="flex items-center gap-4">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full">
                    <x-lucide-bell class="h-4 w-4" />
                  </span>
                  <div>
                    <p class="font-medium text-gray-900">
                      {{ $reminder['title'] }}
                    </p>
                    <p class="text-sm text-gray-500">{{ __('Due') }}: {{ $reminder['due'] }} • {{ __('For') }}: {{ $reminder['person'] }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <button @click="completed = !completed" class="rounded-md px-3 py-2 text-sm font-medium" :class="completed ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-amber-50 text-amber-600 hover:bg-amber-100'">
                    <span x-text="completed ? '{{ __('Completed') }}' : '{{ __('Mark as Done') }}'"></span>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
