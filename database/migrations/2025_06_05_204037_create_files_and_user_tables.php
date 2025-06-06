<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna id (autoincremental)
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Email único
            $table->string('password'); // Contraseña
            $table->rememberToken(); // 'remember_token' para la sesión persistente
            $table->timestamps(); // created_at y updated_at
        });
        
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // = BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 255); // VARCHAR(255)
            $table->text('path'); // TEXT
            $table->string('mime_type', 100); // VARCHAR(100)
            $table->unsignedBigInteger('size'); // BIGINT UNSIGNED
            $table->timestamps(); // created_at y updated_at
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
        Schema::dropIfExists('users');
    }
};
