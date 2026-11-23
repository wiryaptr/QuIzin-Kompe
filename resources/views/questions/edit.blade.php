<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Soal</title>
</head>
<body>
    <h2>Edit Soal</h2>

    <form method="POST" action="{{ route('questions.update', $question) }}">
        @csrf
        @method('PUT')
        @include('questions._form')
        <br>
        <a href="{{ route('quizzes.questions.index', $question->quiz_id) }}">Batal</a>
        <button type="submit">Perbarui</button>
    </form>
</body>
</html>