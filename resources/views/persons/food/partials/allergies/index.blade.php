<?php
/*
 * @var \App\Models\Person $person
 * @var \Illuminate\Support\Collection $food_allergies
 */
?>

<section id="information" class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-wheat-off class="h-5 w-5 text-blue-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Food allergies') }}</h2>
    </div>

    <div class="flex items-center gap-2">
      <a x-target="food-allergies-listing" href="{{ route('person.food.allergies.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
        <x-lucide-pencil class="mr-1 h-3 w-3" />
        {{ __('Edit') }}
      </a>
    </div>
  </div>

  <div id="food-allergies-listing" class="rounded-lg border border-gray-200 bg-white">
    @forelse ($food_allergies as $allergy)
      <div class="items flex gap-x-4 border-b border-gray-200 p-4 first:rounded-t-lg last:rounded-b-lg last:border-b-0 hover:bg-gray-50">
        <div class="flex items-center gap-x-2">
          <div class="shrink-0">
            <img class="h-6 w-6 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $allergy['avatar']['40'] }}" srcset="{{ $allergy['avatar']['40'] }}, {{ $allergy['avatar']['80'] }} 2x" alt="{{ $allergy['name'] }}" loading="lazy" />
          </div>

          @if ($allergy['is_listed'])
            <a href="{{ route('person.show', $allergy['slug']) }}" class="truncate text-sm text-gray-900 underline">{{ $allergy['name'] }}</a>
          @else
            <p class="truncate text-sm text-gray-900">{{ $allergy['name'] }}</p>
          @endif
        </div>
        <span class="text-normal">{{ $allergy['food_allergies'] }}</span>
      </div>
    @empty
      <!-- blank state -->
      <div class="flex flex-col items-center justify-center rounded-lg bg-white p-6 text-center">
        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
          <x-lucide-wheat-off class="h-6 w-6 text-blue-600" />
        </span>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No food allergies recorded yet') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of the food allergies so you know what to avoid in case you invite someone to dinner.') }}</p>
      </div>
    @endforelse
  </div>
</section>
