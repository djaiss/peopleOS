<?php
/*
 * @var Person $person
 * @var array $physicalAppearance
 */
?>

<section id="physical-appearance" class="mb-8">
  <div class="mb-4 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <x-lucide-smile class="h-5 w-5 text-green-500" />
      <h2 class="text-lg font-semibold text-gray-900">{{ __('Physical appearance') }}</h2>
    </div>

    <div class="flex items-center gap-2">
      <a x-target="physical-appearance-details" href="{{ route('person.physical-appearance.edit', $person->slug) }}" class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-600 hover:bg-green-100">
        <x-lucide-pencil class="mr-1 h-3 w-3" />
        {{ __('Edit') }}
      </a>
    </div>
  </div>

  @if ($person->hasPhysicalDetails())
    <div id="physical-appearance-details" class="rounded-lg">
      <div class="grid grid-cols-3 gap-0">
        <!-- this is super barbaric. i'm almost ashamed of it. -->
        @foreach ($physicalAppearance as $field => $data)
          <?php
          // Calculate grid positioning classes
          $isFirstItem = $loop->first;
          $isLastItem = $loop->last;
          $isFirstInRow = $loop->iteration % 3 === 1;
          $isLastInRow = $loop->iteration % 3 === 0 || ($isLastItem && $loop->iteration % 3 !== 0);
          $isInLastRow = $loop->remaining < 3;
          $rowPosition = $loop->iteration % 3 === 0 ? 3 : $loop->iteration % 3;
          $totalColumns = 3;

          // Build classes array for more maintainable class management
          $classes = [];

          // Left border for all first column items
          if ($isFirstInRow) {
            $classes[] = 'border-l';

            // First item in first row gets top-left rounded corner
            if ($isFirstItem) {
              $classes[] = 'rounded-tl-lg';
            }

            // First item in last row gets bottom-left rounded corner
            if ($isInLastRow && ! $isFirstItem) {
              $classes[] = 'rounded-bl-lg';
            }
          }

          // Right border for all last column items and the very last item
          if ($isLastInRow) {
            $classes[] = 'border-r';

            // Last item in first row gets top-right rounded corner
            if ($loop->iteration === $totalColumns) {
              $classes[] = 'rounded-tr-lg';
            }

            // Last item gets bottom-right rounded corner
            if ($isLastItem) {
              $classes[] = 'rounded-br-lg';
            }
          } else {
            // Internal column borders
            $classes[] = 'border-r';
          }

          // Bottom border for all items in the last row
          if ($isInLastRow) {
            $classes[] = 'border-b';
          }

          // Convert array to space-separated string
          $classString = implode(' ', $classes);
          ?>

          <div class="{{ $classString }} flex flex-col border-t border-gray-200 bg-white px-4 py-2">
            <span class="text-xs text-gray-500">{{ $data['label'] }}</span>
            <span class="font-medium">{{ $data['value'] }}</span>
          </div>
        @endforeach
      </div>
    </div>
  @else
    <!-- blank state -->
    <div id="physical-appearance-details" class="flex items-center justify-center gap-x-3 rounded-lg border border-gray-200 bg-white p-4 text-center">
      <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100">
        <x-lucide-smile class="h-6 w-6 text-green-600" />
      </div>
      <p class="text-sm text-gray-500">
        {{ __('Record details of the physical appearance of this person.') }}
      </p>
    </div>
  @endif
</section>
