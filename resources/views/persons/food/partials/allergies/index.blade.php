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
      <a x-target="information-details" href="{{ route('person.information.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
        <x-lucide-pencil class="mr-1 h-3 w-3" />
        {{ __('Edit') }}
      </a>
    </div>
  </div>

  <div id="information-details" class="rounded-lg border border-gray-200 bg-white">
    @forelse ($food_allergies as $allergy)
      <div class="flex items border-b border-gray-200 p-4 hover:bg-gray-50 last:border-b-0 first:rounded-t-lg last:rounded-b-lg">
        <div class="flex items-center gap-x-2">
          <div class="shrink-0">
            <img class="h-6 w-6 rounded-full object-cover p-[0.1875rem] shadow-sm ring-1 ring-slate-900/10" src="{{ $allergy['avatar']['40'] }}" srcset="{{ $allergy['avatar']['40'] }}, {{ $allergy['avatar']['80'] }} 2x" alt="{{ $allergy['name'] }}" loading="lazy" />
          </div>

          @if ($allergy['is_listed'])
            <a href="{{ route('person.show', $allergy['slug']) }}" class="truncate text-sm text-gray-900 underline">{{ $allergy['name'] }}</a>
          @else
            <p class="truncate text-sm text-gray-900">{{ $allergy['name'] }}</p>
          @endif

          <span class="text-sm text-gray-500">ddssd {{ $allergy['food_allergies'] }}</span>
        </div>
      </div>
    @empty
    <!-- blank state -->
    <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-6 text-center">
      <span class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
        <x-lucide-gift class="h-6 w-6 text-blue-600" />
      </span>
      <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No gifts yet') }}</h3>
      <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of the gifts you want to give, the ones you received, and the ones you offered.') }}</p>
    </div>
    @endforelse
  </div>
</section>
