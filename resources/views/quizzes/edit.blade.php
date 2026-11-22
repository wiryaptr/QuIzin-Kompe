<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kuis</title>
</head>
<body>
    <h1>Edit Kuis</h1>

    <form method="POST" action="{{ route('quizzes.update', $quiz) }}">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required>
        <textarea name="description">{{ old('description', $quiz->description) }}</textarea>
        <button type="submit">Simpan perubahan</button>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </form>

    <a href="{{ route('quizzes.show', $quiz) }}">Batal</a>
</body>
</html>