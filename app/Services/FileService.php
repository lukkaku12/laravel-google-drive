<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{


    public function listAllFiles(): array
    {
        // Usa el disco que definiste en config/filesystems.php, por ejemplo 's3'
        $disk = Storage::disk('s3');

        // Opcional: cambiar 'uploads/' si tus archivos están en otra carpeta del bucket
        $files = $disk->files('uploads');

        // Retorna URLs públicas de los archivos
        return array_map(fn($file) => [
            'path' => $file,
            'url' => $disk->url($file),
        ], $files);
    }
    public function uploadFile($file, $path = 'uploads')
    {
        return Storage::disk('s3')->put($path, $file);
    }

    public function getFileUrl($path)
    {
        return Storage::disk('s3')->url($path);
    }

    public function deleteFile($path)
    {
        return Storage::disk('s3')->delete($path);
    }
}