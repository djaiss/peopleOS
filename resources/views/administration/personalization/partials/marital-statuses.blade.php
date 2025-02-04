<?php
/*
 * @var array $maritalStatuses
 */
?>

<h2 class="font-semi-bold mb-1 text-lg">
  {{ __('All the marital statuses in the account') }}
</h2>

<p class="mb-4 text-sm text-zinc-500">
  {{ __('Marital statuses are used to identify the marital status of a person.') }}
</p>

<div class="mb-8 border border-gray-200 bg-white sm:rounded-lg">
  <!-- nb of marital statuses + action -->
  <div id="add-marital-status-form" class="flex items-center justify-between rounded-t-lg border-b border-gray-200 p-3 last:rounded-b-lg last:border-b-0 hover:bg-blue-50">
    @if ($maritalStatuses->isEmpty())
      <p class="text-sm text-zinc-500">{{ __('No marital statuses created') }}</p>
    @else
      <p class="text-sm text-zinc-500">{{ __(':count marital status(es)', ['count' => $maritalStatuses->count()]) }}</p>
    @endif

    <x-button.secondary x-target="add-marital-status-form" href="{{ route('administration.personalization.marital-statuses.new') }}" class="mr-2 text-sm">
      {{ __('New marital status') }}
    </x-button.secondary>
  </div>

  <div id="marital-status-list" class="divide-y divide-gray-200">
    @forelse ($maritalStatuses as $maritalStatus)
      <div id="marital-status-{{ $maritalStatus['id'] }}" class="group flex items-center justify-between p-3 transition-colors duration-200 last:rounded-b-lg">
        <p class="border border-transparent py-1 text-sm font-semibold">{{ $maritalStatus['name'] }}</p>

        <div class="flex gap-2">
          <x-button.invisible x-target="marital-status-{{ $maritalStatus['id'] }}" href="{{ route('administration.personalization.marital-statuses.edit', $maritalStatus['id']) }}" class="hidden text-sm group-hover:block">
            {{ __('Edit') }}
          </x-button.invisible>

          <form x-target="marital-status-{{ $maritalStatus['id'] }}" x-on:ajax:before="
            confirm('Are you sure you want to proceed? This can not be undone.') ||
              $event.preventDefault()
          " action="{{ route('administration.personalization.marital-statuses.destroy', $maritalStatus['id']) }}" method="POST">
            @csrf
            @method('DELETE')

            <x-button.invisible class="hidden text-sm group-hover:block">
              {{ __('Delete') }}
            </x-button.invisible>
          </form>
        </div>
      </div>
    @empty
      <div class="flex flex-col items-center justify-center p-6 text-center">
        <x-lucide-gem class="h-8 w-8 text-gray-400" />
        <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('Marital statuses represent the marital status of a person.') }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new marital status.') }}</p>
      </div>
    @endforelse
  </div>
</div>
