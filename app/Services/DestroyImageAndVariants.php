<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DestroyImageAndVariants
{
    /**
     * Size suffixes for potential variants.
     */
    private array $variantSuffixes = [
        '32x32',
        '40x40',
        '64x64',
        '80x80',
        '128x128',
    ];

    private string $variantExtension = 'webp';

    public function __construct(
        public string $path,
    ) {}

    /**
     * Destroys an image and its predefined variants if they exist.
     */
    public function execute(): void
    {
        if (Storage::exists($this->path)) {
            Log::info('Deleting original image', ['path' => $this->path]);
            Storage::delete($this->path);
        } else {
            Log::warning('Original image not found, skipping deletion', ['path' => $this->path]);
        }

        $baseName = pathinfo($this->path, PATHINFO_FILENAME);
        $directory = pathinfo($this->path, PATHINFO_DIRNAME);

        $directoryPrefix = ($directory === '.' || $directory === '') ? '' : $directory.'/';

        Log::info('Checking for predefined variants', [
            'baseName' => $baseName,
            'directory' => $directoryPrefix ?: './',
        ]);

        $variantsToDelete = [];

        foreach ($this->variantSuffixes as $suffix) {
            $potentialVariantPath = $directoryPrefix.$baseName.'_'.$suffix.'.'.$this->variantExtension;

            if (Storage::exists($potentialVariantPath)) {
                Log::debug('Found existing variant to delete', ['variant' => $potentialVariantPath]);
                $variantsToDelete[] = $potentialVariantPath;
            } else {
                Log::debug('Predefined variant does not exist, skipping', ['variant' => $potentialVariantPath]);
            }
        }

        if ($variantsToDelete !== []) {
            Log::info('Deleting existing variants', ['variants' => $variantsToDelete]);

            Storage::delete($variantsToDelete);
            Log::info('Successfully deleted variants', ['count' => count($variantsToDelete)]);
        } else {
            Log::info('No existing predefined variants found to delete for this image.');
        }
    }
}
