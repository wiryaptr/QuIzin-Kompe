<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Soal - {{ $quiz->title }}</title>
</head>
<body>
    <h2>Soal - {{ $quiz->title }}</h2>
    <p>
        <a href="{{ route('quizzes.show', $quiz) }}">&larr; Kembali ke kuis</a> |
        <a href="{{ route('quizzes.questions.create', $quiz) }}">+ Tambah Soal</a>
    </p>

    @if (session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    @forelse ($questions as $q)
        <div style="border: 1px solid #ccc; padding: 8px; margin-bottom: 8px">
            <strong>{{ $loop->iteration }}. {{ $q->question_text }}</strong>
            <ul>
                @foreach ($q->options as $opt)
                    <li>{{ $opt->option_text }} {{ $opt->is_correct ? '✓ (benar)' : '' }}</li>
                @endforeach
            </ul>
            <a href="{{ route('questions.edit', $q) }}">Edit</a>
            <form method="POST" action="{{ route('questions.destroy', $q) }}"
                style="display:inline" onsubmit="return confirm('Hapus soal ini?')">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </div>
    @empty
        <p>Belum ada soal.</p>
    @endforelse
</body>
</html>