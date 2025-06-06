<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    // Listar archivos del bucket
    public function index(): JsonResponse
{
    try {
    $files = $this->fileService->listAllFiles();

    // Mapear cada archivo a un array con path y URL firmada
    $signedFiles = array_map(function ($file) {
        return [
            'path' => $file['path'], // asegúrate de que 'path' exista en el array $file
            'url' => Storage::disk('s3')->temporaryUrl(
                $file['path'],
                now()->addMinutes(10)
            ),
        ];
    }, $files);

    return response()->json(['files' => $signedFiles], 200);
} catch (\Exception $e) {
    return response()->json([
        'message' => 'Error retrieving files',
        'error' => $e->getMessage()
    ], 500);
}
}

    // Subir archivo
    public function store(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'No file provided'], 400);
        }

        try {
            $path = $this->fileService->uploadFile($request->file('file'));
            $url = $this->fileService->getFileUrl($path);

            return response()->json([
                'message' => 'File uploaded successfully',
                'path' => $path,
                'url' => $url
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Upload failed', 'error' => $e->getMessage()], 500);
        }
    }

    // Obtener URL pública del archivo
    public function show(string $path): JsonResponse
    {
        try {
            $url = $this->fileService->getFileUrl($path);
            return response()->json(['url' => $url], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving file', 'error' => $e->getMessage()], 404);
        }
    }

    // Eliminar archivo
    public function destroy(string $path): JsonResponse
    {
        try {
            $deleted = $this->fileService->deleteFile($path);

            if (!$deleted) {
                return response()->json(['message' => 'File not found'], 404);
            }

            return response()->json(['message' => 'File deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Delete failed', 'error' => $e->getMessage()], 500);
        }
    }
}