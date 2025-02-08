<form x-target="edit-how-we-met-form" id="edit-how-we-met-form" action="{{ route('persons.how-we-met.update', $person->slug) }}" method="POST" class="space-y-4 rounded-lg border border-gray-200 bg-white p-4">
  @csrf
  @method('PUT')

  <h2 class="text-lg font-medium text-gray-900">
    {{ __('How did you meet :name?', ['name' => $person->first_name]) }}
  </h2>

  <!-- Date -->
  <div>
    <x-input-label for="met_date" :value="__('When did you meet?')" />
    <x-text-input x-mask="99/99/9999" placeholder="MM/DD/YYYY" class="mt-1 block w-full" id="met_date" name="met_date" type="text" />
    <x-input-error :messages="$errors->get('met_date')" class="mt-2" />
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

  <!-- Topics Discussed -->
  <div>
    <x-input-label for="topics" :value="__('Topics you discussed')" />
    <x-text-input class="mt-1 block w-full" id="topics" name="topics" type="text" placeholder="{{ __('Separate topics with commas (e.g. Photography, Travel, Music)') }}" />
    <x-input-error :messages="$errors->get('topics')" class="mt-2" />
  </div>

  <div class="mt-6 flex justify-end gap-3">
    <x-button.secondary x-target="edit-how-we-met-form" href="{{ route('persons.show', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
