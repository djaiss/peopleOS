<x-app-layout>
  <div class="flex h-[calc(100vh-48px)] flex-col items-center justify-center bg-gray-50 px-4 text-center sm:px-6 lg:px-8">
    <div class="mx-auto mb-6 max-w-md overflow-hidden rounded-lg border border-gray-200 bg-white p-10 shadow-md dark:border-gray-700 dark:bg-gray-900">
      <!-- Text content -->
      <h3 class="text-2xl font-semibold text-gray-900">
        {{ __('Welcome to :name', ['name' => config('app.name')]) }}
      </h3>

      <p class="mt-4 text-base text-gray-600">
        {{ __('Add your first contact to begin building meaningful relationships.') }}
      </p>

      <!-- Call to action -->
      <div class="mt-8">
        <a href="{{ route('person.new') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-hidden">
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
