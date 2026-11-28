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
                . dibuat {{ $quiz->created_at->translatedFormat('d F Y, H:i') }}

                <a href="{{ route('quizzes.edit', $quiz) }}">Edit</a>
                <a href="{{ route('quizzes.stats', $quiz) }}">Statistik</a>

                <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST"
                    style="display:inline"
                    onsubmit="return confirm('Hapus kuis ini beserta semua soalnya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </li>
        @empty
            <li>Belum ada kuis.</li>
        @endforelse
    </ul>

    {{ $quizzes->links() }}

    <a href="{{ route('dashboard') }}">Kembali</a>
</body>
</html>