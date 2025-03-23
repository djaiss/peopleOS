<form x-target="edit-how-we-met-form" id="edit-how-we-met-form" action="{{ route('person.how-we-met.update', $person->slug) }}" method="POST" x-data="{
  dateType:
    '{{ is_null($person->howWeMetSpecialDate) ? 'unknown' : 'known' }}',
}" class="mb-8 space-y-4 rounded-lg border border-gray-200 bg-white p-4">
  @csrf
  @method('PUT')

  <!-- Date -->
  <div class="flex items-center gap-4">
    <div class="flex items-center gap-x-3">
      <input id="unknown" value="unknown" name="date" type="radio" x-model="dateType" @checked(old('date', is_null($person->howWeMetSpecialDate()))) class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
      <label for="unknown" class="block text-sm/6 font-medium text-gray-900">{{ __('I don\'t know when I met :name', ['name' => $person->first_name]) }}</label>
    </div>

    <div class="flex items-center gap-x-3">
      <input id="known" value="known" name="date" type="radio" x-model="dateType" @checked(old('date', ! is_null($person->howWeMetSpecialDate()))) class="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" />
      <label for="known" class="block text-sm/6 font-medium text-gray-900">{{ __('I know when I met :name', ['name' => $person->first_name]) }}</label>
    </div>
  </div>

  <div x-show="dateType === 'known'" x-transition.duration.100ms class="rounded-lg border border-gray-200 bg-gray-50 p-3">
    <div class="mb-3 grid grid-cols-3 gap-4">
      <div>
        <x-input-label for="how_we_met_year" optional :value="__('Year')" />
        <x-text-input x-mask="9999" value="{{ old('how_we_met_year', $person->howWeMetSpecialDate?->year) }}" placeholder="YYYY" class="mt-1 block w-full" id="how_we_met_year" name="how_we_met_year" type="text" />
        <x-input-error :messages="$errors->get('how_we_met_year')" class="mt-2" />
      </div>
      <div>
        <x-input-label for="how_we_met_month" optional :value="__('Month')" />
        <x-text-input x-mask="99" value="{{ old('how_we_met_month', $person->howWeMetSpecialDate?->month) }}" placeholder="MM" class="mt-1 block w-full" id="how_we_met_month" name="how_we_met_month" type="text" x-on:input="document.getElementById('how_we_met_day').dispatchEvent(new Event('input'))" />
        <x-input-error :messages="$errors->get('how_we_met_month')" class="mt-2" />
      </div>
      <div>
        <x-input-label for="how_we_met_day" optional :value="__('Day')" />
        <x-text-input
          x-mask="99"
          value="{{ old('how_we_met_day', $person->howWeMetSpecialDate?->day) }}"
          placeholder="DD"
          class="mt-1 block w-full"
          id="how_we_met_day"
          name="how_we_met_day"
          type="text"
          x-on:input="
            const dayValue = $el.value.trim();
            const monthValue = document.getElementById('how_we_met_month').value.trim();

            if (dayValue && !monthValue) {
              $el.setCustomValidity('If you specify a day, you must also specify a month');
            } else if (!dayValue && monthValue) {
              $el.setCustomValidity('If you specify a month, you must also specify a day');
            } else {
              $el.setCustomValidity('');
            }
          " />
        <x-input-error :messages="$errors->get('how_we_met_day')" class="mt-2" />
      </div>
    </div>

    <div class="flex gap-2">
      <div class="flex h-6 shrink-0 items-center">
        <div class="group grid size-4 grid-cols-1">
          <input @checked(old('reminder', $person->howWeMetSpecialDate?->should_be_reminded)) value="reminded" id="reminder" name="reminder" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
        </div>
      </div>
      <div class="text-sm/6">
        <label for="reminder" class="font-medium text-gray-900">{{ __('Add a yearly reminder') }}</label>
        <x-input-error :messages="$errors->get('reminder')" class="mt-2" />
      </div>
    </div>
  </div>

  <!-- Location -->
  <div>
    <x-input-label for="how_we_met_location" :value="__('Where did you meet?')" />
    <x-text-input class="mt-1 block w-full" id="how_we_met_location" name="how_we_met_location" type="text" value="{{ old('how_we_met_location', $person->how_we_met_location) }}" placeholder="{{ __('Ex: Coffee Bean, Seattle') }}" />
    <x-input-error :messages="$errors->get('how_we_met_location')" class="mt-2" />
  </div>

  <!-- First Impressions -->
  <div>
    <x-input-label for="how_we_met_first_impressions" :value="__('What were your first impressions?')" />
    <x-textarea name="how_we_met_first_impressions" class="mt-1 block w-full" rows="3" placeholder="{{ __('What stood out about them when you first met?') }}">{{ old('how_we_met_first_impressions', $person->how_we_met_first_impressions) }}</x-textarea>
    <x-input-error :messages="$errors->get('how_we_met_first_impressions')" class="mt-2" />
  </div>

  <!-- The Story -->
  <div>
    <x-input-label for="how_we_met" :value="__('Tell the story')" />
    <x-textarea name="how_we_met" class="mt-1 block w-full" rows="4" placeholder="{{ __('How did you meet? What happened?') }}">{{ old('how_we_met', $person->how_we_met) }}</x-textarea>
    <x-input-error :messages="$errors->get('how_we_met')" class="mt-2" />
  </div>

  <div class="flex items-center justify-between">
    <x-button.secondary x-target="edit-how-we-met-form" href="{{ route('person.show', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
