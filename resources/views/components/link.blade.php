@props([
  'navigate' => false,
  'hover' => false,
])

<a @if($navigate) wire:navigate @endif @if($hover) wire:navigate.hover @endif {{ $attributes->merge(['class' => 'text-blue-500 no-underline hover:underline dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800']) }}>{{ $slot }}</a>
