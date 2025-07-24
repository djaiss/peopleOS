@props([
  'src',
  'alt',
  'width',
  'height',
  'srcset' => null,
  'loading' => 'lazy',
])

<img src="{{ $src }}" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}" @if ($srcset) srcset="{{ $srcset }}" @endif loading="{{ $loading }}" {{ $attributes }} />
