<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $quiz->title }}</title>
</head>
<body>
    <h1>{{ $quiz->title }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p>{{ $quiz->description }}</p>

    <a href="{{ route('quizzes.edit', $quiz) }}">Edit</a>

    <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}" onsubmit="return confirm('Hapus kuis ini?')">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>

    <h2>Soal ({{ $quiz->questions->count() }})</h2>
    <p>Fitur soal menyusul di tahap berikutnya.</p>

    <a href="{{ route('quizzes.index') }}">Kembali ke daftar</a>
</body>
</html>