</main>

<footer class="qik-footer mt-auto">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="qik-brand-link" href="{{ url('/') }}">
                    <span class="qik-brand-sheet qik-brand-sheet--back" aria-hidden="true"></span>
                    <span class="qik-brand-sheet qik-brand-sheet--front" aria-hidden="true"></span>
                    <span class="qik-brand-face">
                        <span class="qik-brand-shape" aria-hidden="true"></span>
                        <span class="qik-brand-text">{{ config('app.name', 'QuIzin Kompe') }}</span>
                    </span>
                </a>
                <p class="mt-3 mb-0 qik-footer-muted">
                    Aplikasi kuis interaktif. Buat kuis, buka room, dan bagikan kodenya.
                    Pemain cukup memasukkan kode dan nama panggilan.
                </p>
            </div>

            <div class="col-6 col-lg-3 offset-lg-1">
                <h2 class="h6 text-white">Jelajahi</h2>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/#cara-main') }}">Cara main</a></li>
                    <li><a href="{{ url('/#fitur') }}">Fitur</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h2 class="h6 text-white">Akun</h2>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ url('/login') }}">Masuk</a></li>
                    <li><a href="{{ url('/register') }}">Daftar</a></li>
                </ul>
            </div>
        </div>

        <hr class="qik-footer-rule my-4">

        <p class="mb-0 small qik-footer-muted">
            &copy; {{ date('Y') }} Quizin Kompe. Proyek akhir Pemrograman Berbasis Platform.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>