<?php

namespace App\Http\Controllers;

use App\Models\FileGroup;
use Illuminate\Http\Request;

class FileGroupController extends Controller
{
    /**
     * Показать список групп
     */
    public function index()
    {
        $groups = FileGroup::withCount('files')->get();
        return view('file-groups.index', compact('groups'));
    }

    /**
     * Показать форму создания группы
     */
    public function create()
    {
        return view('file-groups.create');
    }

    /**
     * Сохранить новую группу
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:file_groups,name',
            'description' => 'nullable|string'
        ]);

        FileGroup::create($request->only('name', 'description'));

        return redirect()->route('file-groups.index')
            ->with('success', 'Группа успешно создана!');
    }

    /**
     * Показать файлы в группе
     */
    public function show(FileGroup $fileGroup)
    {
        $files = $fileGroup->files()->orderBy('created_at', 'desc')->paginate(20);
        return view('file-groups.show', compact('fileGroup', 'files'));
    }

    /**
     * Удалить группу
     */
    public function destroy(FileGroup $fileGroup)
    {
        $fileGroup->files()->update(['file_group_id' => null]);
        $fileGroup->delete();

        return redirect()->route('file-groups.index')
            ->with('success', 'Группа успешно удалена!');
    }
}