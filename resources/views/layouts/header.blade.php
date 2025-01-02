<div class="w-full">
  <!-- main nav -->
  <nav class="max-w-8xl mx-auto flex h-12 items-center justify-between border-b bg-slate-900 px-3 sm:px-6 dark:border-slate-600 dark:bg-gray-800 dark:text-slate-200">
    <div class="dark:highlight-white/5 items-center rounded-lg border border-slate-600 bg-slate-700 px-2 py-1 text-sm sm:flex dark:border-0 dark:border-gray-700 dark:bg-gray-400/20 dark:bg-gray-900">
      <x-link hover href="{{ route('dashboard') }}" class="flex-shrink-0 text-slate-400 hover:text-white dark:text-sky-400">{{ auth()->user()->first_name }}</x-link>

      <!-- information about the current vault -->
      {{--
        <div v-if="layoutData.vault">
        <span class="relative mx-1">
        <svg
        xmlns="http://www.w3.org/2000/svg"
        class="relative inline h-3 w-3"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        </span>
        {{ layoutData.vault.name }}
        </div>
      --}}
    </div>

    <!-- search box -->
    {{--
      <div v-if="insideVault" class="flew-grow relative">
      <svg
      xmlns="http://www.w3.org/2000/svg"
      class="absolute start-2 top-2 h-4 w-4 text-gray-400"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor">
      <path
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="2"
      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
      <input
      type="text"
      class="dark:highlight-white/5 block w-64 rounded-md border border-gray-300 px-2 py-1 text-center placeholder:text-gray-600 hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-0 dark:border-gray-700 dark:bg-slate-900 placeholder:dark:text-gray-400 hover:dark:bg-slate-700 sm:text-sm"
      :placeholder="__('Search something')"
      @focus="goToSearchPage" />
      </div>
    --}}

    <!-- icons -->
    <div class="flex items-center">
      <x-link hover href="{{ route('settings.index') }}" navigate class="group mr-5 flex">
        <x-lucide-settings class="mr-1 w-4 text-slate-400 group-hover:text-white" />

        <span class="text-sm text-slate-400 group-hover:text-white group-hover:no-underline dark:text-sky-400">{{ __('Settings') }}</span>
      </x-link>

      <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf
        <x-link class="group flex" href="{{ route('logout') }}">
          <x-lucide-log-out class="mr-1 w-4 text-slate-400 group-hover:text-white" />

          <span @click.prevent="$root.submit();" class="text-sm text-slate-400 hover:text-white hover:no-underline dark:text-sky-400">{{ __('Logout') }}</span>
        </x-link>
      </form>
    </div>
  </nav>

  <!-- vault sub menu -->
  {{--
    <nav v-if="insideVault" class="bg-white dark:border-slate-300/10 dark:bg-gray-900 sm:border-b">
    <div class="max-w-8xl mx-auto hidden px-4 py-2 sm:px-6 md:block">
    <div class="flex items-baseline justify-between space-x-6">
    <ul class="list-none text-sm font-medium">
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.dashboard"
    :class="{
    'bg-blue-700 text-white dark:bg-blue-300 dark:text-gray-900':
    $page.component === 'Vault/Dashboard/Index',
    }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Dashboard') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.contacts"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Contact') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Contacts') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.calendar"
    v-if="layoutData.vault.visibility.show_calendar_tab"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Calendar') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Calendar') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.journals"
    v-if="layoutData.vault.visibility.show_journal_tab"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Journal') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Journals') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.groups"
    v-if="layoutData.vault.visibility.show_group_tab"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Group') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Groups') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.companies"
    v-if="layoutData.vault.visibility.show_companies_tab"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Companies') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Companies') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.tasks"
    v-if="layoutData.vault.visibility.show_tasks_tab"
    :class="{
    'bg-blue-700 text-white dark:bg-blue-300 dark:text-gray-900':
    $page.component.startsWith('Vault/Dashboard/Task'),
    }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Tasks') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.reports"
    v-if="layoutData.vault.visibility.show_reports_tab"
    :class="{
    'bg-blue-700 text-white dark:bg-blue-300 dark:text-gray-900':
    $page.component.startsWith('Vault/Reports'),
    }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Reports') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    :href="layoutData.vault.url.files"
    v-if="layoutData.vault.visibility.show_files_tab"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Files') }"
    class="me-2 rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
    {{ __('Files') }}
    </InertiaLink>
    </li>
    <li class="inline">
    <InertiaLink
    v-if="layoutData.vault.permission.at_least_editor"
    :href="layoutData.vault.url.settings"
    :class="{ 'bg-blue-700 text-white': $page.component.startsWith('Vault/Settings') }"
    class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white">
    {{ __('Vault settings') }}
    </InertiaLink>
    </li>
    </ul>
    </div>
    </div>
    </nav>
  --}}
</div>
