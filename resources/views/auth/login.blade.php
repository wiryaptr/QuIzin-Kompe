<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | QuizHoodie</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Ingat saya</label>
        <button type="submit">Login</button>
        @error('email') <p>{{ $message }}</p> @enderror
    </form>

    <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
</body>
</html>