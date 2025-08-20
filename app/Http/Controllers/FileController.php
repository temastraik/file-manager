<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Показать список всех файлов с возможностью поиска
     */
    public function index(Request $request)
    {
        $files = File::with('group')
        ->when($request->search, function ($query, $search) {
            return $query->where('original_name', 'like', "%{$search}%");
        })
        ->when($request->type, function ($query, $type) {
            return $query->where('file_type', $type);
        })
        ->when($request->group, function ($query, $group) {
            return $query->where('file_group_id', $group);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        $groups = FileGroup::all();
        $fileTypes = [
            File::TYPE_TEXT => 'Текстовые',
            File::TYPE_IMAGE => 'Графические',
            File::TYPE_AUDIO => 'Звуковые',
            File::TYPE_VIDEO => 'Видео',
            File::TYPE_ARCHIVE => 'Архивные',
            File::TYPE_OTHER => 'Другие'
        ];
        
        return view('files.index', compact('files', 'groups', 'fileTypes'));
    }

    /**
     * Показать форму загрузки файлов
     */
    public function create()
    {
        $groups = FileGroup::all();
        return view('files.create', compact('groups'));
    }

    /**
     * Сохранить загруженные файлы
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240',
            'file_group_id' => 'nullable|exists:file_groups,id'
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $uploadedFile) {
            try {
                $originalName = $uploadedFile->getClientOriginalName();
                $extension = $uploadedFile->getClientOriginalExtension();
                $mimeType = $uploadedFile->getMimeType();
                $size = $uploadedFile->getSize();
                $fileType = File::getFileType($extension);

                $storageName = Str::random(40) . '.' . $extension;
                $path = $uploadedFile->storeAs('user_files', $storageName);

                $file = File::create([
                    'original_name' => $originalName,
                    'storage_name' => $storageName,
                    'extension' => $extension,
                    'mime_type' => $mimeType,
                    'size' => $size,
                    'file_type' => $fileType,
                    'path' => $path,
                    'file_group_id' => $request->file_group_id
                ]);

                $uploadedFiles[] = $file;
            } catch (\Exception $e) {
                \Log::error('File upload error: ' . $e->getMessage());
            }
        }

        return redirect()->route('files.index')
            ->with('success', 'Файлы успешно загружены!');
    }

    /**
     * Скачать файл
     */
    public function download(File $file)
    {
        if (!Storage::exists($file->path)) {
            return redirect()->back()->with('error', 'Файл не найден!');
        }

        return Storage::download($file->path, $file->original_name);
    }

    /**
     * Удалить файл
     */
    public function destroy(File $file)
    {
        try {
            Storage::delete($file->path);
            
            $file->delete();

            return redirect()->route('files.index')
                ->with('success', 'Файл успешно удален!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ошибка при удалении файла!');
        }
    }

    /**
     * Показать файлы по типу
     */
    public function byType($type)
    {
        $files = File::where('file_type', $type)
            ->with('group')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $fileTypes = [
            File::TYPE_TEXT => 'Текстовые',
            File::TYPE_IMAGE => 'Графические',
            File::TYPE_AUDIO => 'Звуковые',
            File::TYPE_VIDEO => 'Видео',
            File::TYPE_ARCHIVE => 'Архивные',
            File::TYPE_OTHER => 'Другие'
        ];

        return view('files.by-type', compact('files', 'type', 'fileTypes'));
    }
}