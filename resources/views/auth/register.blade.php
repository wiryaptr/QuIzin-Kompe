@php
    $pageTitle = 'Daftar';$activeNav = 'register';
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
                <h1 class="qik-form-title">Buat akun</h1>
                <p class="qik-form-hint">Akun dibutuhkan untuk membuat kuis dan menjadi host. Untuk bermain, cukup kode room.</p>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3 mb-0" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="qik-field">
                        <label for="name" class="qik-field-tag qik-field-tag--nama">Nama</label>
                        <input type="text" class="qik-input" id="name" name="name"
                               value="{{ old('name') }}" maxlength="255" autocomplete="name" required>
                    </div>

                    <div class="qik-field">
                        <label for="email" class="qik-field-tag qik-field-tag--email">Email</label>
                        <input type="email" class="qik-input" id="email" name="email"
                               value="{{ old('email') }}" maxlength="255" autocomplete="email" required>
                    </div>

                    <div class="qik-field">
                        <label for="password" class="qik-field-tag qik-field-tag--password">Kata Sandi</label>
                        <input type="password" class="qik-input" id="password" name="password"
                               minlength="8" maxlength="72" autocomplete="new-password" aria-describedby="passwordHelp" required>
                    </div>
                    <div id="passwordHelp" class="form-text text-light opacity-75">Minimal 8 karakter.</div>

                    <div class="qik-field">
                        <label for="password_confirmation" class="qik-field-tag qik-field-tag--confirm-password">Ulangi Sandi</label>
                        <input type="password" class="qik-input" id="password_confirmation" name="password_confirmation"
                               maxlength="72" autocomplete="new-password" required>
                    </div>

                    <button type="submit" class="btn btn-ink btn-lg w-100">Daftar</button>
                </form>

                <p class="qik-form-note text-center mt-4 mb-0">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</section>

@include('includes.footer')