<?php
/*
 * @var Person $person
 * @var Collection $persons
 * @var Collection $gifts
 * @var int $ideaGiftsCount
 * @var int $receivedGiftsCount
 * @var int $offeredGiftsCount
 */
?>

<x-app-layout>
  <div class="grid h-[calc(100vh-48px)] grid-cols-[280px_320px_1fr] divide-x divide-gray-200">
    <!-- Section A: Contact List -->
    @include('persons.partials.persons-list', ['persons' => $persons, 'person' => $person])

    <!-- Section B: Contact Overview -->
    @include('persons.partials.profile')

    <!-- Section C: Detail View -->
    <div class="h-[calc(100vh-48px)] overflow-y-auto bg-gray-50">
      <div class="mx-auto max-w-3xl p-6">
        <section id="information" class="mb-8">
          <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <x-lucide-gift class="h-5 w-5 text-blue-500" />
              <h2 class="text-lg font-semibold text-gray-900">{{ __('Gifts') }}</h2>
            </div>

            <div class="flex items-center gap-2">
              <a x-target="add-gift-form" href="{{ route('persons.gifts.new', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-1 text-sm font-medium text-blue-600 hover:bg-blue-100">
                <x-lucide-plus class="mr-1 h-3 w-3" />
                {{ __('Add') }}
              </a>
            </div>
          </div>

          <!-- form to add a gift -->
          <div id="add-gift-form"></div>

          <!-- list of gifts -->
          @if ($ideaGiftsCount > 0 || $receivedGiftsCount > 0 || $offeredGiftsCount > 0)
            <div id="gift-list" class="flex gap-x-4">
              <!-- tabs -->
              <div class="flex flex-col gap-2">
                <a x-target="gift-list" href="{{ route('persons.gifts.tab.update', [$person->slug, 'idea']) }}" class="{{ $person->gift_tab_shown === 'idea' ? 'border-blue-200 bg-blue-50' : 'border-transparent hover:border-blue-200 hover:bg-blue-50' }} group flex cursor-pointer items-center justify-between gap-2 rounded-lg border px-2 py-1">
                  <div class="flex items-center gap-2">
                    <x-lucide-gift class="h-4 w-4 text-blue-500" />
                    <p class="text-gray-900">{{ __('Ideas') }}</p>
                  </div>

                  <div class="rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 group-hover:bg-blue-200">{{ $ideaGiftsCount }}</div>
                </a>

                <a x-target="gift-list" href="{{ route('persons.gifts.tab.update', [$person->slug, 'received']) }}" class="{{ $person->gift_tab_shown === 'received' ? 'border-blue-200 bg-blue-50' : 'border-transparent hover:border-blue-200 hover:bg-blue-50' }} group flex cursor-pointer items-center justify-between gap-2 rounded-lg border px-2 py-1">
                  <div class="flex items-center gap-2">
                    <x-lucide-hand-heart class="h-4 w-4 text-blue-500" />
                    <p class="text-gray-900">{{ __('Received') }}</p>
                  </div>

                  <div class="rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 group-hover:bg-blue-200">{{ $receivedGiftsCount }}</div>
                </a>

                <a x-target="gift-list" href="{{ route('persons.gifts.tab.update', [$person->slug, 'given']) }}" class="{{ $person->gift_tab_shown === 'given' ? 'border-blue-200 bg-blue-50' : 'border-transparent hover:border-blue-200 hover:bg-blue-50' }} group flex cursor-pointer items-center justify-between gap-2 rounded-lg border px-2 py-1">
                  <div class="flex items-center gap-2">
                    <x-lucide-hand-coins class="h-4 w-4 text-blue-500" />
                    <p class="text-gray-900">{{ __('Offered') }}</p>
                  </div>

                  <div class="rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-600 group-hover:bg-blue-200">{{ $offeredGiftsCount }}</div>
                </a>
              </div>

              <!-- list of gifts -->
              <div id="gifts" class="flex-1">
                <div class="w-full rounded-lg border border-gray-200">
                  @forelse ($gifts as $gift)
                    <div class="group flex items-center justify-between border-b border-gray-200 bg-white first:rounded-t-lg last:rounded-b-lg last:border-b-0">
                      <div class="p-4">
                        <div class="">
                          <p class="mb-1 text-gray-900">{{ $gift->name }}</p>
                          <p class="flex items-center gap-2">
                            @if ($gift->occasion)
                              <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-800">{{ $gift->occasion }}</span>
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="flex gap-2 p-4">
                        <x-button.invisible class="hidden text-sm group-hover:block">
                          {{ __('Edit') }}
                        </x-button.invisible>

                        <form x-on:ajax:before="
                          confirm('Are you sure you want to proceed? This can not be undone.') ||
                            $event.preventDefault()
                        " action="" method="POST">
                          @csrf
                          @method('DELETE')

                          <x-button.invisible class="hidden text-sm group-hover:block">
                            {{ __('Delete') }}
                          </x-button.invisible>
                        </form>
                      </div>
                    </div>
                  @empty
                    <!-- blank state -->
                    <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-6 text-center">
                      <span class="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                        <x-lucide-gift class="h-6 w-6 text-blue-600" />
                      </span>
                      <p class="text-gray-900">{{ __('No gifts yet') }}</p>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>
          @else
            <!-- blank state -->
            <div class="flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-6 text-center">
              <span class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                <x-lucide-gift class="h-6 w-6 text-blue-600" />
              </span>
              <h3 class="mt-2 text-sm font-semibold text-gray-900">{{ __('No gifts yet') }}</h3>
              <p class="mt-1 text-sm text-gray-500">{{ __('Keep track of the gifts you want to give, the ones you received, and the ones you offered.') }}</p>
            </div>
          @endif
        </section>
      </div>
    </div>
  </div>
</x-app-layout>
