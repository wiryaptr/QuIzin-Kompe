<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal</title>
</head>
<body>
    <h2>Tambah Soal - {{ $quiz->title }}</h2>

    <form method="POST" action="{{ route('quizzes.questions.store', $quiz) }}">
        @csrf
        @include('questions._form')
        <br>
        <a href="{{ route('quizzes.questions.index', $quiz) }}">Batal</a>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>