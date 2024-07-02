@props([
  'value',
])

<label {{ $attributes->merge(['class' => 'mb-2 block text-sm dark:text-gray-300 text-gray-700']) }}>
  {{ $value ?? $slot }}
</label>
