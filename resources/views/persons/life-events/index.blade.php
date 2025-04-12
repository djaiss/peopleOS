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
          {{ __('Life events') }}
        </h1>

        <div class="flex flex-col gap-y-7 border-l border-gray-300 ml-3">
          <div class="flex gap-x-3 relative">
            <div class="bg-amber-300 p-1 rounded-full absolute -left-3">
              <x-lucide-check class="h-4 w-4 text-gray-500" />
            </div>
            <div class="relative group pl-6">

                <span class="group-hover:bg-amber-100 px-1 rounded">ceci est une phrase de test pour voir jusqua ou ca va et comment on va faire pour etre le plus beua mec du monde</span>
                <span class="inline-block text-gray-500 ml-3">Jan 5, 2022</span>
                <div class="absolute top-0 -right-8 rounded-full border border-gray-200 bg-white p-1">
                  <x-lucide-bell-ring class="h-4 w-4 text-gray-400" />
                </div>
            </div>
          </div>
          <div class="flex gap-x-3 relative">
            <div class="bg-amber-300 p-1 rounded-full absolute -left-3">
              <x-lucide-check class="h-4 w-4 text-gray-500" />
            </div>
            <div class="relative pl-6 flex flex-col gap-y-3">
              <div class="">
                <p>ceci est une phrase de test pour voir jusqua ou ca va et comment on va faire pour etre le plus beua mec du monde
                <span class="ml-3 text-gray-500">Jan 5, 2022</span>
                </p>
              </div>
              <div class="rounded-lg p-3 bg-white border border-gray-300">Since all mailable classes generated using the make:mail command make use of the Illuminate\Bus\Queueable trait, you may call the onQueue and onConnection methods on any mailable class instance, allowing you to specify the connection and queue name for the message:</div>
            </div>
          </div>
          <div class="flex gap-x-3 relative">
            <div class="bg-amber-300 p-1 rounded-full absolute -left-3">
              <x-lucide-check class="h-4 w-4 text-gray-500" />
            </div>
            <div class="relative pl-6 flex gap-x-3">
              <div class="">
                <p>ceci est une phrase de test pour voir jusqua ou ca va et comment on va faire pour etre le plus beua mec du monde
                <span class="ml-3 text-gray-500">Jan 5, 2022</span>
                </p>
              </div>
            </div>
          </div>
          <div class="flex gap-x-3 relative">
            <div class="bg-amber-300 p-1 rounded-full absolute -left-3">
              <x-lucide-check class="h-4 w-4 text-gray-500" />
            </div>
            <div class="relative pl-6 flex gap-x-3">
              <div class="">
                <p>ceci est une phrase de test pour voir jusqua ou ca va et comment on va faire pour etre le plus beua mec du monde
                <span class="ml-3 text-gray-500">Jan 5, 2022</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
