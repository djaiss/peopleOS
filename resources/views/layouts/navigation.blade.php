<nav class="bg-white sm:border-b dark:border-slate-300/10 dark:bg-gray-900">
  <div class="max-w-8xl mx-auto hidden px-4 py-2 sm:px-6 md:block">
    <div class="flex items-baseline justify-between space-x-6">
      <ul class="list-none text-sm font-medium">
        <li class="inline">
          <x-link href="'layoutData.vault.url.dashboard'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Dashboard') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="{{ route('vaults.contacts.index', $vault->id) }}" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-30 {{ request()->routeIs('vaults.contacts.*') ? 'bg-gray-700 text-white no-underline' : '' }}" dusk="navigation-contact-link">
            {{ __('Contacts') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.calendar'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Calendar') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.journals'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Journals') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.groups'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Groups') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.companies'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Companies') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.tasks'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Tasks') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.reports'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Reports') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link href="'layoutData.vault.url.files'" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300">
            {{ __('Files') }}
          </x-link>
        </li>
        <li class="inline">
          <x-link navigate href="{{ route('vaults.settings.index', $vault->id) }}" class="rounded-md px-2 py-1 hover:bg-gray-700 hover:text-white hover:no-underline dark:bg-sky-400/20 dark:text-slate-400 hover:dark:text-slate-300 {{ request()->routeIs('vaults.settings.index') ? 'bg-gray-700 text-white no-underline' : '' }}" dusk="navigation-contact-link">
            {{ __('Vault settings') }}
          </x-link>
        </li>
      </ul>
    </div>
  </div>
</nav>
