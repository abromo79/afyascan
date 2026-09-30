<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    /**
     * Store an uploaded image on the public disk, replacing any previous file.
     */
    protected function storeImage(?UploadedFile $file, string $directory, ?string $existing = null): ?string
    {
        if (! $file) {
            return $existing;
        }

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        return $file->store($directory, 'public');
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
