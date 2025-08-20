<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Файловый менеджер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Файловый менеджер</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Поиск и фильтры -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('files.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Поиск по имени..." value="{{ request('search', '') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="type" class="form-control">
                                <option value="">Все типы</option>
                                @foreach($fileTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="group" class="form-control">
                                <option value="">Все группы</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Фильтровать</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="mb-3">
            <a href="{{ route('files.create') }}" class="btn btn-success">Загрузить файлы</a>
            <a href="{{ route('file-groups.index') }}" class="btn btn-info">Управление группами</a>
        </div>

        <!-- Список файлов -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Файлы ({{ $files->total() }})</h5>
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
                                    <th>Группа</th>
                                    <th>Дата загрузки</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>{{ $file->original_name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $fileTypes[$file->file_type] ?? $file->file_type }}</span>
                                        </td>
                                        <td>{{ $file->readable_size }}</td>
                                        <td>
                                            @if($file->group)
                                                <span class="badge bg-info">{{ $file->group->name }}</span>
                                            @else
                                                <span class="text-muted">Без группы</span>
                                            @endif
                                        </td>
                                        <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-primary">Скачать</a>
                                            <form action="{{ route('files.destroy', $file) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить файл?')">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $files->links() }}
                @else
                    <p class="text-muted">Файлы не найдены.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>