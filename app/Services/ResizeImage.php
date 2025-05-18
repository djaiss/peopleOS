<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ResizeImage
{
    private string $folderName = '';

    public function __construct(
        public string $path,
        public int $maxWidth,
        public int $maxHeight,
    ) {}

    /**
     * Resize an image based on the max width and height provided, while
     * preserving the aspect ratio.
     *
     * This method will generate a @2x variant of the image for retina displays.
     */
    public function execute(): void
    {
        $this->checkFolderName();
        $fileName = $this->generateNewFilename($this->maxWidth, $this->maxHeight);
        $this->resize($fileName, $this->maxWidth, $this->maxHeight);

        // generate @2x variant
        $fileName = $this->generateNewFilename($this->maxWidth * 2, $this->maxHeight * 2);
        $this->resize($fileName, $this->maxWidth * 2, $this->maxHeight * 2);
    }

    private function checkFolderName(): void
    {
        if (str_contains($this->path, '/')) {
            $this->folderName = dirname($this->path);
        }
    }

    private function generateNewFilename(int $width, int $height): string
    {
        $baseName = pathinfo($this->path, PATHINFO_FILENAME);

        if ($this->folderName !== '') {
            return $this->folderName . '/' . $baseName . '_' . $width . 'x' . $height . '.webp';
        }

        return $baseName . '_' . $width . 'x' . $height . '.webp';
    }

    private function resize(string $fileName, int $maxWidth, int $maxHeight): void
    {
        Log::info('Loading image', ['path' => $this->path]);
        $imageContent = Storage::disk('public')->get($this->path);

        $image = Image::read($imageContent);

        Log::info('Scaling down image', ['maxWidth' => $maxWidth, 'maxHeight' => $maxHeight]);
        $image->scaleDown($maxWidth, $maxHeight);

        Log::info('Encoding image');
        $encodedImage = $image->toWebp(90);

        Log::info('Saving image');
        Storage::disk('public')->put($fileName, $encodedImage);

        Log::info('Image saved', ['path' => $fileName]);
    }
}
