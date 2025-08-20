<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление группами файлов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Управление группами файлов</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('file-groups.create') }}" class="btn btn-success">Создать группу</a>
            <a href="{{ route('files.index') }}" class="btn btn-secondary">Назад к файлам</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($groups->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Описание</th>
                                <th>Количество файлов</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->description ?? '—' }}</td>
                                    <td>{{ $group->files_count }}</td>
                                    <td>
                                        <a href="{{ route('file-groups.show', $group) }}" class="btn btn-sm btn-info">Просмотр</a>
                                        <form action="{{ route('file-groups.destroy', $group) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить группу? Файлы останутся без группы.')">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">Группы не созданы.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>