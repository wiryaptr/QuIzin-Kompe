<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | QuizHoodie</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Halo, {{ auth()->user()->name }}</p>
    <a href="{{ route('quizzes.index') }}">Kuis Saya</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>