<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Kuis</title>
</head>
<body>
    <h1>Buat Kuis</h1>

    <form method="POST" action="{{ route('quizzes.store') }}">
        @csrf
        <input type="text" name="title" value="{{ old('title') }}" placeholder="Judul kuis" required>
        <textarea name="description" placeholder="Deskripsi (opsional)">{{ old('description') }}</textarea>
        <button type="submit">Simpan</button>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </form>

    <a href="{{ route('quizzes.index') }}">Batal</a>
</body>
</html>