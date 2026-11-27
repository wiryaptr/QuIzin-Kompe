@php
    $pageTitle = 'Masuk';
    $activeNav = 'login';
@endphp

@include('includes.header')

<section class="qik-auth">
    <div class="container">
        <div class="qik-auth-stack">
            <div class="qik-stack qik-stack--backdrop" aria-hidden="true">
                <span class="qik-stack-sheet qik-stack-sheet--back"></span>
                <span class="qik-stack-sheet qik-stack-sheet--front"></span>  
                <div class="qik-stack-face"><div class="qik-stack-card"></div></div>
            </div>
            <div class="qik-glass">
                <h1 class="qik-form-title">Masuk</h1>
                <p class="qik-form-hint">Masuk untuk membuat kuis dan membuka room.</p>

                @if (session('status') || session('notice'))
                    <div class="alert alert-success mt-3" role="status">
                        {{ session('status') ?? session('notice') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-3" role="alert">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="qik-field">
                        <label for="email" class="qik-field-tag qik-field-tag--email">Email</label>
                        <input type="email" class="qik-input" id="email" name="email"
                            value="{{ old('email') }}" maxlength="255" autocomplete="email" required>
                    </div>

                    <div class="qik-field">
                        <label for="password" class="qik-field-tag qik-field-tag--nama">Kata sandi</label>
                        <input type="password" class="qik-input" id="password" name="password"
                            maxlength="72" autocomplete="current-password" required>
                    </div>

                    <div class="mt-3">
                        <label class="d-inline-flex align-items-center gap-2">
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-ink btn-lg w-100">Masuk</button>
                </form>

                <p class="qik-form-note text-center mt-4 mb-1">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                </p>
                <p class="text-center small qik-form-note mb-0">
                    Hanya ingin bermain? Masukkan kode room di <a href="{{ url('/') }}">beranda</a>.
                </p>
            </div>
        </div>
    </div>
</section>

@include('includes.footer')