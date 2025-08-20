<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Группа: {{ $fileGroup->name }} - Файловый менеджер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Группа: {{ $fileGroup->name }}</h2>
        
        @if($fileGroup->description)
            <p class="text-muted">{{ $fileGroup->description }}</p>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('file-groups.index') }}" class="btn btn-secondary">← Назад к списку групп</a>
            <a href="{{ route('files.index') }}" class="btn btn-info">К списку файлов</a>
        </div>

        <!-- Список файлов в группе -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Файлы в группе ({{ $files->total() }})</h5>
            </div>
            <div class="card-body">
                @if($files->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Имя файла</th>
                                    <th>Тип</th>
                                    <th>Размер</th>
                                    <th>Дата загрузки</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>{{ $file->original_name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                @switch($file->file_type)
                                                    @case(\App\Models\File::TYPE_TEXT) Текстовый @break
                                                    @case(\App\Models\File::TYPE_IMAGE) Графический @break
                                                    @case(\App\Models\File::TYPE_AUDIO) Звуковой @break
                                                    @case(\App\Models\File::TYPE_VIDEO) Видео @break
                                                    @case(\App\Models\File::TYPE_ARCHIVE) Архивный @break
                                                    @default Другой
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>{{ $file->readable_size }}</td>
                                        <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-primary">Скачать</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $files->links() }}
                @else
                    <p class="text-muted">В этой группе нет файлов.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>