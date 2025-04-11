<x-marketing-layout :marketing-page="$marketingPage" :view-name="$viewName">
  <!-- breadcrumb -->
  <div class="border-b border-gray-200 py-3 text-sm">
    <div class="mx-auto flex max-w-7xl items-center gap-x-2 px-6 lg:px-8 xl:px-0">
      <a href="{{ route('marketing.index') }}" class="text-blue-500 hover:underline">{{ __('Home') }}</a>
      <span class="text-gray-500">&gt;</span>
      <span class="text-gray-600">{{ __('Documentation') }}</span>
    </div>
  </div>

  <div class="relative mx-auto max-w-7xl px-6 lg:px-8 xl:px-0">
    <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-[250px_1fr]">
      <!-- Sidebar -->
      <div class="hidden w-full flex-shrink-0 flex-col justify-self-end sm:border-r sm:border-gray-200 sm:pr-3 lg:flex">
        <div x-data="{
          openApiDocumentation: true,
          accountManagementDocumentation: true,
          personsDocumentation: true,
          journalDocumentation: true,
        }" class="bg-light dark:bg-dark z-10 pt-16">
          <!-- api documentation -->
          <div @click="open = !open" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200 hover:bg-blue-50">
            <h3>{{ __('Person management') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <div @click="open = !open" class="mb-2 flex items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200 hover:bg-blue-50">
            <h3>{{ __('Journal management') }}</h3>
            <x-lucide-chevron-right x-bind:class="open ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <!-- api documentation -->
          <div @click="openApiDocumentation = !openApiDocumentation" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 hover:border-gray-200 hover:bg-blue-50">
            <h3>{{ __('API documentation') }}</h3>
            <x-lucide-chevron-right x-bind:class="openApiDocumentation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
          </div>

          <!-- sub menu -->
          <div x-show="openApiDocumentation" class="mb-10 ml-3">
            <div class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.introduction') }}" class="{{ request()->routeIs('marketing.docs.api.introduction') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Introduction') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.authentication') }}" class="{{ request()->routeIs('marketing.docs.api.authentication') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Authentication') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.errors') }}" class="{{ request()->routeIs('marketing.docs.api.errors') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Errors') }}</a>
              </div>
            </div>

            <!-- account management -->
            <div @click="accountManagementDocumentation = !accountManagementDocumentation" class="mb-3 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 pl-3 text-xs text-gray-500 uppercase hover:border-gray-200 hover:bg-blue-50">
              <h3>{{ __('Account management') }}</h3>
              <x-lucide-chevron-right x-bind:class="accountManagementDocumentation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
            </div>
            <div x-show="accountManagementDocumentation" class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.profile') }}" class="{{ request()->routeIs('marketing.docs.api.profile') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Profile') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.logs') }}" class="{{ request()->routeIs('marketing.docs.api.logs') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Logs') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.api-management') }}" class="{{ request()->routeIs('marketing.docs.api.api-management') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('API management') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.genders') }}" class="{{ request()->routeIs('marketing.docs.api.genders') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Genders') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.task-categories') }}" class="{{ request()->routeIs('marketing.docs.api.task-categories') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Task categories') }}</a>
              </div>
            </div>

            <!-- persons -->
            <div @click="personsDocumentation = !personsDocumentation" class="mb-3 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 pl-3 text-xs text-gray-500 uppercase hover:border-gray-200 hover:bg-blue-50">
              <h3>{{ __('Persons') }}</h3>
              <x-lucide-chevron-right x-bind:class="personsDocumentation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
            </div>
            <div x-show="personsDocumentation" class="mb-3 flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.gifts') }}" class="{{ request()->routeIs('marketing.docs.api.gifts') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Gifts') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.tasks') }}" class="{{ request()->routeIs('marketing.docs.api.tasks') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Tasks for persons') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.notes') }}" class="{{ request()->routeIs('marketing.docs.api.notes') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Notes') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.update-age') }}" class="{{ request()->routeIs('marketing.docs.api.update-age') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Update a person\'s age') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.update-physical-appearance') }}" class="{{ request()->routeIs('marketing.docs.api.update-physical-appearance') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Update physical appearance') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.life-events') }}" class="{{ request()->routeIs('marketing.docs.api.life-events') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Life events') }}</a>
              </div>
            </div>

            <!-- journal -->
            <div @click="journalDocumentation = !journalDocumentation" class="mb-2 flex cursor-pointer items-center justify-between rounded-md border border-transparent px-2 py-1 pl-3 text-xs text-gray-500 uppercase hover:border-gray-200 hover:bg-blue-50">
              <h3>{{ __('Journal') }}</h3>
              <x-lucide-chevron-right x-bind:class="journalDocumentation ? 'rotate-90' : ''" class="h-4 w-4 text-gray-500 transition-transform duration-300" />
            </div>
            <div x-show="journalDocumentation" class="flex flex-col gap-y-2">
              <div>
                <a href="{{ route('marketing.docs.api.journals') }}" class="{{ request()->routeIs('marketing.docs.api.journals') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Journals') }}</a>
              </div>
              <div>
                <a href="{{ route('marketing.docs.api.entries') }}" class="{{ request()->routeIs('marketing.docs.api.entries') ? 'border-l-blue-400' : 'border-l-transparent' }} block border-l-3 pl-3 hover:border-l-blue-400 hover:underline">{{ __('Entries') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="py-16">
        {{ $slot }}
      </div>
    </div>
  </div>
</x-marketing-layout>
