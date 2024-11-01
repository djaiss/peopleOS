@props([
  'value',
  'optional' => false,
])

<label {{ $attributes->merge(['class' => 'mb-2 block text-sm font-medium dark:text-gray-300 text-gray-700']) }}>
  {{ $value ?? $slot }}

  @if ($optional)
    <span class="ml-1 inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ __('optional') }}</span>
  @endif
</label>
