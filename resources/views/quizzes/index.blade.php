<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuis Saya</title>
</head>
<body>
    <h1>Kuis Saya</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('quizzes.create') }}">+ Buat kuis</a>

    <ul>
        @forelse ($quizzes as $quiz)
            <li>
                <a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->title }}</a>
                ({{ $quiz->questions_count }} soal)
            </li>
        @empty
            <li>Belum ada kuis.</li>
        @endforelse
    </ul>

    <a href="{{ route('dashboard') }}">Kembali</a>
</body>
</html>