<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = [
        'user_id',      // Relación con el usuario dueño del archivo
        'name',         // Nombre original del archivo
        'path',         // Ruta en S3
        'mime_type',    // Tipo MIME (ej: application/pdf)
        'size',         // Tamaño en bytes
    ];

    /**
     * Relación con el usuario dueño del archivo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
