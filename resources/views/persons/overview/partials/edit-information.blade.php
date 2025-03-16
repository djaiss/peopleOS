<div id="information-details" class="rounded-lg border border-gray-200 bg-white">
  <form x-target="information-details" x-target.back="information-form" id="information-form" action="{{ route('persons.information.update', $person->slug) }}" method="post">
    @csrf
    @method('put')

    <!-- timezone -->
    <div class="grid grid-cols-3 items-center rounded-t-lg border-b p-3 last:rounded-b-lg hover:bg-blue-50">
      <x-input-label for="timezone" :value="__('Timezone')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <select id="timezone" name="timezone" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">
          <optgroup label="UTC">
            <option value="UTC" @selected($person->timezone === 'UTC')>Coordinated Universal Time (UTC) - UTC+00:00</option>
          </optgroup>
          <optgroup label="Africa">
            <option value="Africa/Casablanca" @selected($person->timezone === 'Africa/Casablanca')>Western European Time (WET) - UTC+00:00</option>
            <option value="Africa/Lagos" @selected($person->timezone === 'Africa/Lagos')>West Africa Time (WAT) - UTC+01:00</option>
            <option value="Africa/Cairo" @selected($person->timezone === 'Africa/Cairo')>Eastern European Time (EET) - UTC+02:00</option>
            <option value="Africa/Johannesburg" @selected($person->timezone === 'Africa/Johannesburg')>South Africa Standard Time (SAST) - UTC+02:00</option>
          </optgroup>
          <optgroup label="America">
            <option value="America/St_Johns" @selected($person->timezone === 'America/St_Johns')>Newfoundland Standard Time (NST) - UTC-03:30</option>
            <option value="America/Halifax" @selected($person->timezone === 'America/Halifax')>Atlantic Standard Time (AST) - UTC-04:00</option>
            <option value="America/New_York" @selected($person->timezone === 'America/New_York')>Eastern Standard Time (EST) - UTC-05:00</option>
            <option value="America/Chicago" @selected($person->timezone === 'America/Chicago')>Central Standard Time (CST) - UTC-06:00</option>
            <option value="America/Denver" @selected($person->timezone === 'America/Denver')>Mountain Standard Time (MST) - UTC-07:00</option>
            <option value="America/Los_Angeles" @selected($person->timezone === 'America/Los_Angeles')>Pacific Standard Time (PST) - UTC-08:00</option>
            <option value="America/Anchorage" @selected($person->timezone === 'America/Anchorage')>Alaska Standard Time (AKST) - UTC-09:00</option>
            <option value="Pacific/Honolulu" @selected($person->timezone === 'Pacific/Honolulu')>Hawaii-Aleutian Standard Time (HAST) - UTC-10:00</option>
          </optgroup>
          <optgroup label="Antarctica">
            <option value="Antarctica/Palmer" @selected($person->timezone === 'Antarctica/Palmer')>Chile Summer Time (CLST) - UTC-03:00</option>
            <option value="Antarctica/McMurdo" @selected($person->timezone === 'Antarctica/McMurdo')>New Zealand Standard Time (NZST) - UTC+12:00</option>
          </optgroup>
          <optgroup label="Asia">
            <option value="Asia/Dubai" @selected($person->timezone === 'Asia/Dubai')>Gulf Standard Time (GST) - UTC+04:00</option>
            <option value="Asia/Karachi" @selected($person->timezone === 'Asia/Karachi')>Pakistan Standard Time (PKT) - UTC+05:00</option>
            <option value="Asia/Kolkata" @selected($person->timezone === 'Asia/Kolkata')>India Standard Time (IST) - UTC+05:30</option>
            <option value="Asia/Dhaka" @selected($person->timezone === 'Asia/Dhaka')>Bangladesh Standard Time (BST) - UTC+06:00</option>
            <option value="Asia/Jakarta" @selected($person->timezone === 'Asia/Jakarta')>Western Indonesia Time (WIB) - UTC+07:00</option>
            <option value="Asia/Shanghai" @selected($person->timezone === 'Asia/Shanghai')>China Standard Time (CST) - UTC+08:00</option>
            <option value="Asia/Tokyo" @selected($person->timezone === 'Asia/Tokyo')>Japan Standard Time (JST) - UTC+09:00</option>
            <option value="Asia/Seoul" @selected($person->timezone === 'Asia/Seoul')>Korea Standard Time (KST) - UTC+09:00</option>
          </optgroup>
          <optgroup label="Australia">
            <option value="Australia/Perth" @selected($person->timezone === 'Australia/Perth')>Australian Western Standard Time (AWST) - UTC+08:00</option>
            <option value="Australia/Adelaide" @selected($person->timezone === 'Australia/Adelaide')>Australian Central Standard Time (ACST) - UTC+09:30</option>
            <option value="Australia/Sydney" @selected($person->timezone === 'Australia/Sydney')>Australian Eastern Standard Time (AEST) - UTC+10:00</option>
          </optgroup>
          <optgroup label="Europe">
            <option value="Europe/London" @selected($person->timezone === 'Europe/London')>Greenwich Mean Time (GMT) - UTC+00:00</option>
            <option value="Europe/Berlin" @selected($person->timezone === 'Europe/Berlin')>Central European Time (CET) - UTC+01:00</option>
            <option value="Europe/Moscow" @selected($person->timezone === 'Europe/Moscow')>Moscow Standard Time (MSK) - UTC+03:00</option>
          </optgroup>
          <optgroup label="Pacific">
            <option value="Pacific/Auckland" @selected($person->timezone === 'Pacific/Auckland')>New Zealand Standard Time (NZST) - UTC+12:00</option>
            <option value="Pacific/Fiji" @selected($person->timezone === 'Pacific/Fiji')>Fiji Time (FJT) - UTC+12:00</option>
          </optgroup>
        </select>

        <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
      </div>
    </div>

    <!-- nationalities -->
    <div class="grid grid-cols-3 items-center border-b p-3 last:rounded-b-lg hover:bg-blue-50">
      <x-input-label for="nationalities" :value="__('Nationalities')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input id="nationalities" name="nationalities" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->nationalities" />
      </div>
    </div>

    <!-- languages -->
    <div class="grid grid-cols-3 items-center p-3 last:rounded-b-lg hover:bg-blue-50">
      <x-input-label for="languages" :value="__('Languages')" class="col-span-1" />
      <div class="col-span-2 w-full justify-self-end">
        <x-text-input id="languages" name="languages" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 disabled:text-gray-400 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600" :value="$person->languages" />
      </div>
    </div>

    <!-- actions -->
    <div class="flex justify-between border-t border-gray-200 p-3">
      <x-button.secondary x-target="information-details" href="{{ route('persons.index', $person->slug) }}" class="mr-2">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary>
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</div>
