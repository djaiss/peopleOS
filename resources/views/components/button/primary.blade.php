@props([
  'href',
  'type' => 'button',
  'navigate' => false,
  'hover' => false,
])

@isset($href)
  <a href="{{ $href }}" @if($navigate) wire:navigate @endif @if($hover) wire:navigate.hover @endif {{ $attributes->merge(['class' => 'rounded-md border border-indigo-700 bg-indigo-500 px-3 py-1 font-semibold text-white shadow-sm hover:bg-indigo-700']) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['type' => 'submit', 'class' => 'rounded-md border border-indigo-700 bg-indigo-500 px-3 py-1 font-semibold text-white shadow-sm hover:bg-indigo-700']) }}>
    {{ $slot }}
  </button>
@endif
