<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание группы файлов - Файловый менеджер</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Создание новой группы файлов</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('file-groups.index') }}" class="btn btn-secondary">← Назад к списку групп</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('file-groups.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Название группы *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        <div class="form-text">Уникальное название для группы файлов</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        <div class="form-text">Необязательное описание группы</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Создать группу</button>
                    <a href="{{ route('file-groups.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>