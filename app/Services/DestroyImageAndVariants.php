<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class DestroyImageAndVariants
{
    public function __construct(
        public string $path,
    ) {}

    /**
     * Destroy an image and all its resized versions.
     */
    public function execute(): void
    {
        // Delete the original file
        Storage::delete($this->path);

        // Get the base name without extension
        $baseName = pathinfo($this->path, PATHINFO_FILENAME);
        $directory = pathinfo($this->path, PATHINFO_DIRNAME);

        // If we're in a directory, add trailing slash
        $directory = $directory !== '.' ? $directory.'/' : '';

        // Find all variants (files with same base name and _*x*.webp pattern)
        $pattern = $baseName.'_*x*.webp';

        // Get all matching files
        $variants = Storage::files($directory, $pattern);

        // Delete all variants
        foreach ($variants as $variant) {
            Storage::delete($variant);
        }
    }
}
