<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Statistik {{ $quiz->title }}</title>
</head>
<body>
    <h1>Statistik: {{ $quiz->title }}</h1>
    <p>Soal diurutkan dari yang paling sering salah.</p>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>#</th>
                <th>Soal</th>
                <th>Dijawab</th>
                <th>Salah</th>
                <th>% Salah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questions as $i => $question)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->total_answers }}</td>
                    <td>{{ $question->wrong_answers }}</td>
                    <td>{{ $question->wrong_percent }}%</td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada soal.</td></tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('quizzes.show', $quiz) }}">Kembali</a>
</body>
</html>