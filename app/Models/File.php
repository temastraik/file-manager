<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'storage_name',
        'extension',
        'mime_type',
        'size',
        'file_type',
        'path',
        'file_group_id'
    ];

    // Константы для типов файлов
    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    const TYPE_ARCHIVE = 'archive';
    const TYPE_OTHER = 'other';

    /**
     * Получить группу, к которой принадлежит файл
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(FileGroup::class, 'file_group_id');
    }

    /**
     * Определить тип файла по расширению
     */
    public static function getFileType(string $extension): string
    {
        $textExtensions = ['txt', 'doc', 'docx', 'pdf', 'rtf', 'odt', 'html', 'htm', 'csv'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff'];
        $audioExtensions = ['mp3', 'wav', 'ogg', 'flac', 'aac', 'wma'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        $archiveExtensions = ['zip', 'rar', '7z', 'tar', 'gz', 'bz2'];

        if (in_array(strtolower($extension), $textExtensions)) {
            return self::TYPE_TEXT;
        } elseif (in_array(strtolower($extension), $imageExtensions)) {
            return self::TYPE_IMAGE;
        } elseif (in_array(strtolower($extension), $audioExtensions)) {
            return self::TYPE_AUDIO;
        } elseif (in_array(strtolower($extension), $videoExtensions)) {
            return self::TYPE_VIDEO;
        } elseif (in_array(strtolower($extension), $archiveExtensions)) {
            return self::TYPE_ARCHIVE;
        } else {
            return self::TYPE_OTHER;
        }
    }

    /**
     * Получить читаемый размер файла
     */
    public function getReadableSizeAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = $this->size;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}