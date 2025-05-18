<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get the image variant URL of an image for a given size.
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
