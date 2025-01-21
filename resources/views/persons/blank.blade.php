<x-app-layout>
  <div class="flex h-[calc(100vh-48px)] flex-col items-center justify-center bg-gray-50 px-4 text-center sm:px-6 lg:px-8">
    <div class="mx-auto max-w-md">
      <!-- SVG Illustration -->
      <svg class="mx-auto h-48 w-48 text-gray-300" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="250" cy="150" r="100" stroke="currentColor" stroke-width="20" />
        <circle cx="250" cy="450" r="180" stroke="currentColor" stroke-width="20" stroke-dasharray="20 20" />
        <path d="M175 220 L100 450" stroke="currentColor" stroke-width="16" />
        <path d="M325 220 L400 450" stroke="currentColor" stroke-width="16" />
        <path d="M250 250 L250 450" stroke="currentColor" stroke-width="16" />
      </svg>

      <!-- Text content -->
      <h3 class="mt-6 text-2xl font-semibold text-gray-900">
        {{ __('Welcome to :name', ['name' => config('app.name')]) }}
      </h3>

      <p class="mt-4 text-base text-gray-600">
        {{ __('Start recording what you know about the people you care about. Add your first contact to begin building meaningful relationships.') }}
      </p>

      <!-- Call to action -->
      <div class="mt-8">
        <a wire:navigate href="{{ route('persons.new') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          <x-lucide-plus class="h-5 w-5" />
          {{ __('Add your first person') }}
        </a>
      </div>

      <!-- Help text -->
      <p class="mt-4 text-sm text-gray-500">
        {{ __('You can add family members, friends, colleagues, or anyone else you want to keep in touch with.') }}
      </p>
    </div>
  </div>
</x-app-layout>
