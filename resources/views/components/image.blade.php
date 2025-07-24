@props([
    'src',
    'alt',
    'width',
    'height',
    'srcset',
    'loading' => 'lazy',
])

<img src="{{ $src }}" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}" srcset="{{ $srcset }}" loading="{{ $loading }}" {{ $attributes }}>
