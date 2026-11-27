</main>
<?php // includes/footer.php ?>

<footer class="qh-footer mt-auto">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="qh-brand text-white text-decoration-none" href="<?= url() ?>">
                    <span class="qh-cord" aria-hidden="true"></span><?= e(APP_NAME) ?>
                </a>
                <p class="mt-3 mb-0 qh-footer-muted">
                    Aplikasi kuis interaktif. Buat kuis, buka room, dan bagikan kodenya.
                    Pemain cukup memasukkan kode dan nama panggilan.
                </p>
            </div>

            <div class="col-6 col-lg-3 offset-lg-1">
                <h2 class="h6 text-white">Jelajahi</h2>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?= url() ?>">Beranda</a></li>
                    <li><a href="<?= url('#cara-main') ?>">Cara main</a></li>
                    <li><a href="<?= url('#fitur') ?>">Fitur</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-3">
                <h2 class="h6 text-white">Akun</h2>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?= url('auth/login.php') ?>">Masuk</a></li>
                    <li><a href="<?= url('auth/register.php') ?>">Daftar</a></li>
                </ul>
            </div>
        </div>

        <hr class="qh-footer-rule my-4">

        <p class="mb-0 small qh-footer-muted">
            &copy; <?= date('Y') ?> <?= e(APP_NAME) ?>. Proyek akhir Pemrograman Berbasis Platform.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= url('assets/js/main.js') ?>"></script>
</body>
</html>
