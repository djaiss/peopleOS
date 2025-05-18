<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get the image variant URL of an image for a given size.
     * For instance, given a filename like "Ross_Geller.jpg",
     * the function will return the URL of the image variant
     * like "Ross_Geller_64x64.webp".
     *
     * @param string $path The path to the image.
     * @param int $size The size of the image.
     *
     * @return string The URL of the image variant.
     */
    public static function getImageVariantPath(string $path, int $size): string
    {
        $directory = pathinfo($path, PATHINFO_DIRNAME);
        if ($directory !== '.') {
            $directory .= '/';
        } else {
            $directory = '';
        }

        $baseName = pathinfo($path, PATHINFO_FILENAME);
        $variantPath = $directory . $baseName . '_' . $size . 'x' . $size . '.webp';

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk(config('filesystems.default'));
        return $disk->url($variantPath);
    }
}
