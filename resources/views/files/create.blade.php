<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файлов - Файловый менеджер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Загрузка файлов</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('files.index') }}" class="btn btn-secondary">← Назад к списку файлов</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="files" class="form-label">Выберите файлы (макс. 10MB каждый)</label>
                        <input type="file" name="files[]" id="files" class="form-control" multiple required>
                        <div class="form-text">Можно выбрать несколько файлов одновременно</div>
                    </div>

                    <div class="mb-3">
                        <label for="file_group_id" class="form-label">Группа (опционально)</label>
                        <select name="file_group_id" id="file_group_id" class="form-control">
                            <option value="">Без группы</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Загрузить</button>
                    <a href="{{ route('files.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>