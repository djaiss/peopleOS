@props([
  'href',
])

@isset($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => 'cursor-pointer rounded-md border border-indigo-700 bg-indigo-500 px-3 py-1 font-semibold text-white shadow-xs hover:bg-indigo-700']) }}>{{ $slot }}</a>
@else
  <button type="submit" {{ $attributes->merge(['class' => 'cursor-pointer rounded-md border border-indigo-700 bg-indigo-500 px-3 py-1 font-semibold text-white shadow-xs hover:bg-indigo-700']) }}>
    {{ $slot }}
  </button>
@endif
