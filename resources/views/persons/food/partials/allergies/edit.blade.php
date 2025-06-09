<?php
/*
 * @var \App\Models\Person $person
 * @var \Illuminate\Support\Collection $persons
 */
?>

<form x-target="food-allergies-listing" id="food-allergies-listing" action="{{ route('person.food.allergies.update', $person->slug) }}" method="POST" class="rounded-lg border border-gray-200 bg-white">
  @csrf
  @method('PUT')

  @foreach ($persons as $human)
    @if ($human instanceof \App\Models\Child)
      <div class="items flex items-center justify-between border-b border-gray-200 p-4 first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-gray-50">
        <p class="truncate text-sm text-gray-900">{{ $human->name }}</p>

        <div>
          <x-text-input id="child_{{ $human->id }}" name="child_allergies[{{ $human->id }}]" type="text" class="block w-full" placeholder="{{ __('Add allergies') }}" value="{{ $human->food_allergies }}" />
          <x-input-error :messages="$errors->get('child_allergies.'.$human->id)" class="mt-2" />
        </div>
      </div>
    @else
      <div class="items flex justify-between border-b border-gray-200 p-4 first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-gray-50">
        <div class="flex items-center gap-x-2">
          <div class="shrink-0">
            <img class="h-6 w-6 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $human->getAvatar(40) }}" srcset="{{ $human->getAvatar(40) }}, {{ $human->getAvatar(40) }} 2x" alt="{{ $human->name }}" loading="lazy" />
          </div>

          <p class="truncate text-sm text-gray-900">{{ $human->name }}</p>
        </div>

        <div>
          <x-text-input id="person_{{ $human->id }}" name="person_allergies[{{ $human->id }}]" type="text" class="block w-full" placeholder="{{ __('Add allergies') }}" value="{{ $human->food_allergies }}" />
          <x-input-error :messages="$errors->get('person_allergies.'.$human->id)" class="mt-2" />
        </div>
      </div>
    @endif
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
