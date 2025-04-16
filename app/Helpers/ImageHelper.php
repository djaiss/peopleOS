<?php

declare(strict_types=1);

namespace App\Helpers;

class ImageHelper
{
    /**
     * Get the image variant of an image for a given size.
     */
    public static function getImageVariantPath(string $path, int $size): string
    {
        $baseName = pathinfo($path, PATHINFO_FILENAME);
        $folderName = '';

        if (str_contains($path, '/')) {
            $folderName = dirname($path).'/';
        }

        return $folderName.$baseName.'_'.$size.'x'.$size.'.webp';
    }
}
