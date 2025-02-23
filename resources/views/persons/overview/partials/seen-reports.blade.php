<?php
/*
 * @var Person $person
 */
?>

<section class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-eye class="h-5 w-5 text-amber-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Encounters') }}</h2>
    </div>
  </div>

  <div class="flex gap-4 rounded-lg border border-gray-200 bg-white">
    <div class="flex flex-col gap-4 border-r border-gray-200 p-4">
      <p class="text-sm text-gray-600">{{ __('Times seen') }}</p>
      <div class="flex items-baseline gap-2">
        <p class="text-2xl font-semibold">24</p>
        <p class="text-sm text-gray-500">{{ __('in :year', ['year' => date('Y')]) }}</p>
        <span class="text-gray-400">·</span>
        <p class="text-sm text-gray-500">31 {{ __('in :year', ['year' => date('Y') - 1]) }}</p>
      </div>
    </div>
    <div class="p-4">
      <p class="mb-3 text-sm text-gray-600">{{ __('Have you seen :name lately?', ['name' => $person->first_name]) }}</p>

      <div class="flex flex-wrap gap-2">
        <form action="" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now() }}" />
          <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-100">
            {{ __('Today') }}
          </button>
        </form>

        <form action="" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now()->subDay() }}" />
          <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-100">
            {{ __('Yesterday') }}
          </button>
        </form>

        <form action="" method="POST" class="inline">
          @csrf
          <input type="hidden" name="seen_at" value="{{ now()->subDays(2) }}" />
          <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-100">
            {{ __('2 days ago') }}
          </button>
        </form>

        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'custom-date')" class="inline-flex items-center gap-1 rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-600 ring-1 ring-gray-300 ring-inset hover:bg-gray-50">
          <x-lucide-calendar-plus class="h-4 w-4" />
          {{ __('Custom date') }}
        </button>
      </div>
    </div>
  </div>

  <!-- Recent Encounters -->
  <div class="mt-4 rounded-lg border border-gray-200 bg-white">
    <h3 class="border-b border-gray-200 px-4 py-3 text-sm font-medium text-gray-700">{{ __('Recent encounters') }}</h3>
    <div class="divide-y divide-gray-200">
      @foreach ([['date' => now()->subDays(2), 'period' => 'At Central Perk'], ['date' => now()->subDays(5), 'period' => 'Birthday party'], ['date' => now()->subDays(12), 'period' => 'Coffee meeting'], ['date' => now()->subDays(25), 'period' => 'Dinner at Monica\'s']] as $encounter)
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-3">
            <div class="rounded-full bg-indigo-50 p-2">
              <x-lucide-eye class="h-4 w-4 text-indigo-600" />
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">{{ $encounter['period'] }}</p>
              <p class="text-sm text-gray-500">{{ $encounter['date']->diffForHumans() }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Custom Date Modal -->
<x-modal name="custom-date" :show="false" maxWidth="sm">
  <form method="POST" action="" class="p-6">
    @csrf

    <h2 class="text-lg font-medium text-gray-900">
      {{ __('When did you see :name?', ['name' => $person->first_name]) }}
    </h2>

    <div class="mt-6">
      <x-input-label for="seen_at" :value="__('Date')" />
      <x-text-input id="seen_at" name="seen_at" type="date" class="mt-1 block w-full" required />
      <x-input-error :messages="$errors->get('seen_at')" class="mt-2" />
    </div>

    <div class="mt-6">
      <x-input-label for="period_of_time" :value="__('Additional details (optional)')" />
      <x-text-input id="period_of_time" name="period_of_time" type="text" class="mt-1 block w-full" placeholder="{{ __('e.g. Coffee meeting, Birthday party') }}" />
      <x-input-error :messages="$errors->get('period_of_time')" class="mt-2" />
    </div>

    <div class="mt-6 flex justify-end gap-3">
      <x-button.secondary x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-button.secondary>

      <x-button.primary type="submit">
        {{ __('Save') }}
      </x-button.primary>
    </div>
  </form>
</x-modal>
