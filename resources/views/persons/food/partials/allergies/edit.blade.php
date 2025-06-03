<?php
/*
 * @var \App\Models\Person $person
 * @var \Illuminate\Support\Collection $persons
 */
?>

<form x-target="food-allergies-listing" id="food-allergies-listing" action="{{ route('person.food.allergies.update', $person->slug) }}" method="POST" class="rounded-lg border border-gray-200 bg-white">
  @csrf
  @method('PUT')

  @foreach ($persons as $person)
    <div class="items flex justify-between border-b border-gray-200 p-4 first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-gray-50">
      <div class="flex items-center gap-x-2">
        <div class="shrink-0">
          <img class="h-6 w-6 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $person->getAvatar(40) }}" srcset="{{ $person->getAvatar(40) }}, {{ $person->getAvatar(40) }} 2x" alt="{{ $person->name }}" loading="lazy" />
        </div>

        <p class="truncate text-sm text-gray-900">{{ $person->name }}</p>
      </div>

      <div>
        <x-text-input id="person_{{ $person->id }}" name="person_allergies[{{ $person->id }}]" type="text" class="block w-full" placeholder="{{ __('Add allergies') }}" value="{{ $person->food_allergies }}" />
        <x-input-error :messages="$errors->get('person_allergies.'.$person->id)" class="mt-2" />
      </div>
    </div>
  @endforeach

  <div class="flex items-center justify-between p-4">
    <x-button.secondary x-target="food-allergies-listing" href="{{ route('person.food.index', $person->slug) }}">
      {{ __('Cancel') }}
    </x-button.secondary>

    <x-button.primary>
      {{ __('Save') }}
    </x-button.primary>
  </div>
</form>
