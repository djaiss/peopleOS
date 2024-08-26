@props([
  'href',
])

@isset($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => 'button dark:box-s relative border-zinc-900 bg-white dark:border-zinc-100 dark:bg-gray-800 dark:text-gray-100']) }}>{{ $slot }}</a>
@else
  <button hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' {{ $attributes->merge(['type' => 'button', 'class' => 'button dark:box-s relative border-zinc-900 bg-white dark:border-zinc-100 dark:bg-gray-800 dark:text-gray-100']) }}>
    {{ $slot }}
  </button>
@endif
