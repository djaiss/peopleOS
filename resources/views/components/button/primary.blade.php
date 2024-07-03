@props([
  'href',
  'type' => 'button',
])

@isset($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => 'button dark:box-s primary relative border-zinc-900 bg-white dark:border-zinc-100 dark:bg-gray-800 dark:text-gray-100']) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['type' => 'submit', 'class' => 'button dark:box-s primary relative border-zinc-900 bg-white dark:border-zinc-100 dark:bg-gray-800 dark:text-gray-100']) }}>
    {{ $slot }}
  </button>
@endif
