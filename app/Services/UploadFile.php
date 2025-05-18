<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFile
{
    private string $path;

    public function __construct(
        public $file,
        public string $folderName,
    ) {}

    /**
     * Upload a file.
     */
    public function execute(): string
    {
        Log::info('Uploading file ' . $this->file->getClientOriginalName());
        $this->path = Storage::disk(config('filesystems.default'))
            ->putFile($this->folderName, $this->file);

        Log::info('File uploaded ' . $this->path);

        return $this->path;
    }
}
