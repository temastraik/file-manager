<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * Получить файлы, принадлежащие группе
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}