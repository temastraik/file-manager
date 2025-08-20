<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name'); // Оригинальное имя файла
            $table->string('storage_name'); // Имя файла в хранилище
            $table->string('extension'); // Расширение файла
            $table->string('mime_type'); // MIME тип
            $table->bigInteger('size'); // Размер файла в байтах
            $table->string('file_type'); // Тип файла (текстовый, графический и т.д.)
            $table->string('path'); // Путь к файлу
            $table->foreignId('file_group_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};