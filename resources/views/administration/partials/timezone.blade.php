<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('Timezone') }}
</h2>

<form x-target="timezone-form" x-target.back="timezone-form" id="timezone-form" action="{{ route('administration.timezone.update') }}" method="post" class="mb-8 border border-gray-200 bg-white sm:rounded-lg" x-data="{ showActions: false }">
  @csrf
  @method('put')

  <!-- timezone -->
  <div class="grid grid-cols-3 items-center rounded-t-lg p-3 last:rounded-b-lg hover:bg-blue-50">
    <x-input-label for="timezone" :value="__('Timezone')" class="col-span-1" />
    <div class="col-span-2 w-full justify-self-end">
      <select @focus="showActions = true" @blur="showActions = false" id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
        <optgroup label="UTC">
          <option value="UTC" @selected(auth()->user()->timezone === 'UTC')>Coordinated Universal Time (UTC) - UTC+00:00</option>
        </optgroup>
        <optgroup label="Africa">
          <option value="Africa/Casablanca" @selected(auth()->user()->timezone === 'Africa/Casablanca')>Western European Time (WET) - UTC+00:00</option>
          <option value="Africa/Lagos" @selected(auth()->user()->timezone === 'Africa/Lagos')>West Africa Time (WAT) - UTC+01:00</option>
          <option value="Africa/Cairo" @selected(auth()->user()->timezone === 'Africa/Cairo')>Eastern European Time (EET) - UTC+02:00</option>
          <option value="Africa/Johannesburg" @selected(auth()->user()->timezone === 'Africa/Johannesburg')>South Africa Standard Time (SAST) - UTC+02:00</option>
        </optgroup>
        <optgroup label="America">
          <option value="America/St_Johns" @selected(auth()->user()->timezone === 'America/St_Johns')>Newfoundland Standard Time (NST) - UTC-03:30</option>
          <option value="America/Halifax" @selected(auth()->user()->timezone === 'America/Halifax')>Atlantic Standard Time (AST) - UTC-04:00</option>
          <option value="America/New_York" @selected(auth()->user()->timezone === 'America/New_York')>Eastern Standard Time (EST) - UTC-05:00</option>
          <option value="America/Chicago" @selected(auth()->user()->timezone === 'America/Chicago')>Central Standard Time (CST) - UTC-06:00</option>
          <option value="America/Denver" @selected(auth()->user()->timezone === 'America/Denver')>Mountain Standard Time (MST) - UTC-07:00</option>
          <option value="America/Los_Angeles" @selected(auth()->user()->timezone === 'America/Los_Angeles')>Pacific Standard Time (PST) - UTC-08:00</option>
          <option value="America/Anchorage" @selected(auth()->user()->timezone === 'America/Anchorage')>Alaska Standard Time (AKST) - UTC-09:00</option>
          <option value="Pacific/Honolulu" @selected(auth()->user()->timezone === 'Pacific/Honolulu')>Hawaii-Aleutian Standard Time (HAST) - UTC-10:00</option>
        </optgroup>
        <optgroup label="Antarctica">
          <option value="Antarctica/Palmer" @selected(auth()->user()->timezone === 'Antarctica/Palmer')>Chile Summer Time (CLST) - UTC-03:00</option>
          <option value="Antarctica/McMurdo" @selected(auth()->user()->timezone === 'Antarctica/McMurdo')>New Zealand Standard Time (NZST) - UTC+12:00</option>
        </optgroup>
        <optgroup label="Asia">
          <option value="Asia/Dubai" @selected(auth()->user()->timezone === 'Asia/Dubai')>Gulf Standard Time (GST) - UTC+04:00</option>
          <option value="Asia/Karachi" @selected(auth()->user()->timezone === 'Asia/Karachi')>Pakistan Standard Time (PKT) - UTC+05:00</option>
          <option value="Asia/Kolkata" @selected(auth()->user()->timezone === 'Asia/Kolkata')>India Standard Time (IST) - UTC+05:30</option>
          <option value="Asia/Dhaka" @selected(auth()->user()->timezone === 'Asia/Dhaka')>Bangladesh Standard Time (BST) - UTC+06:00</option>
          <option value="Asia/Jakarta" @selected(auth()->user()->timezone === 'Asia/Jakarta')>Western Indonesia Time (WIB) - UTC+07:00</option>
          <option value="Asia/Shanghai" @selected(auth()->user()->timezone === 'Asia/Shanghai')>China Standard Time (CST) - UTC+08:00</option>
          <option value="Asia/Tokyo" @selected(auth()->user()->timezone === 'Asia/Tokyo')>Japan Standard Time (JST) - UTC+09:00</option>
          <option value="Asia/Seoul" @selected(auth()->user()->timezone === 'Asia/Seoul')>Korea Standard Time (KST) - UTC+09:00</option>
        </optgroup>
        <optgroup label="Australia">
          <option value="Australia/Perth" @selected(auth()->user()->timezone === 'Australia/Perth')>Australian Western Standard Time (AWST) - UTC+08:00</option>
          <option value="Australia/Adelaide" @selected(auth()->user()->timezone === 'Australia/Adelaide')>Australian Central Standard Time (ACST) - UTC+09:30</option>
          <option value="Australia/Sydney" @selected(auth()->user()->timezone === 'Australia/Sydney')>Australian Eastern Standard Time (AEST) - UTC+10:00</option>
        </optgroup>
        <optgroup label="Europe">
          <option value="Europe/London" @selected(auth()->user()->timezone === 'Europe/London')>Greenwich Mean Time (GMT) - UTC+00:00</option>
          <option value="Europe/Berlin" @selected(auth()->user()->timezone === 'Europe/Berlin')>Central European Time (CET) - UTC+01:00</option>
          <option value="Europe/Moscow" @selected(auth()->user()->timezone === 'Europe/Moscow')>Moscow Standard Time (MSK) - UTC+03:00</option>
        </optgroup>
        <optgroup label="Pacific">
          <option value="Pacific/Auckland" @selected(auth()->user()->timezone === 'Pacific/Auckland')>New Zealand Standard Time (NZST) - UTC+12:00</option>
          <option value="Pacific/Fiji" @selected(auth()->user()->timezone === 'Pacific/Fiji')>Fiji Time (FJT) - UTC+12:00</option>
        </optgroup>
      </select>

      <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
    </div>
  </div>

  <!-- actions -->
  <div x-cloak x-show="showActions" x-transition:enter="transition duration-200 ease-out" x-transition:enter-start="-translate-y-2 transform opacity-0" x-transition:enter-end="translate-y-0 transform opacity-100" x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="translate-y-0 transform opacity-100" x-transition:leave-end="-translate-y-2 transform opacity-0" class="flex justify-between border-t border-gray-200 p-3">
    <x-button.secondary @click="showActions = false" class="mr-2">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
