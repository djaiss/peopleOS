@props([
  'href',
  'navigate' => false,
  'hover' => false,
])

@isset($href)
  <a href="{{ $href }}" @if($navigate) wire:navigate @endif @if($hover) wire:navigate.hover @endif {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1 font-semibold text-gray-700 shadow-xs transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25']) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-md border border-transparent hover:border hover:border-gray-300 bg-white px-3 py-1 font-semibold text-gray-700 hover:shadow-xs transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
  </button>
@endif
