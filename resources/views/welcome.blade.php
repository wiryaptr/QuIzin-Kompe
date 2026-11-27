<?php
    $pageTitle = 'Kuis interaktif untuk kelas dan komunitas';
    $activeNav = 'home';
?>      
@include('includes.header');

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <!-- HERO: form masuk room adalah hal pertama yang dicari pemain -->
    <section class="qik-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h1 class="display-4 qik-display">Punya kode room? Langsung main.</h1>
                <p class="lead mt-3 mb-4 qik-lead">
                    Tidak perlu akun untuk ikut bermain. Mau bikin kuis sendiri dan jadi host?
                    Daftar dulu, kuis pertamamu siap dalam beberapa menit.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn" href="<?= url('auth/register.php') ?>">Buat kuis</a>
                    <a class="btn" href="#cara-main">Cari kuis</a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="qik-stack">
                    <span class="qik-stack-sheet qik-stack-sheet--back" aria-hidden="true"></span>
                    <span class="qik-stack-sheet qik-stack-sheet--front" aria-hidden="true"></span>
                    <div class="qik-stack-face">
                        <div class="qik-stack-card">
                            <h2 class="qik-form-title">Masuk ke room</h2>
                            <p class="qik-form-hint">Kode room dibagikan oleh host.</p>

                            <!-- action: nanti diarahkan ke room/join.php -->
                            <form action="<?= url('room/join.php') ?>" method="post" novalidate>
                                <div class="qik-field">
                                    <label for="roomCode" class="qik-field-tag">Kode room</label>
                                    <input type="text" class="qik-input qik-code" id="roomCode" name="code"
                                        maxlength="6" autocomplete="off" autocapitalize="characters"
                                        placeholder="ABC123" required>
                                </div>  
                                <button type="submit" class="btn w-100 mt-4">Masuk room</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<!-- CARA MAIN: ini memang urutan langkah, jadi bernomor -->
    <section class="py-5 qik-section" id="cara-main">
    <div class="container">
        <h2 class="qik-h2 mb-2">Tiga langkah dari soal sampai papan skor</h2>
        <p class="text-body-secondary mb-5 qik-measure">
            Host menyiapkan kuis, pemain bergabung lewat kode, lalu skor langsung terhitung.
        </p>

        <ol class="qik-steps list-unstyled mb-0">
            <li>
                <span class="qik-step-no">1</span>
                <div>
                    <h3 class="h5">Buat kuis</h3>
                    <p class="mb-0">Tulis soal pilihan ganda dengan empat opsi dan atur batas waktu tiap soal.</p>
                </div>
            </li>
            <li>
                <span class="qik-step-no">2</span>
                <div>
                    <h3 class="h5">Buka room</h3>
                    <p class="mb-0">Pilih kuis, buka room, lalu bagikan kode yang muncul ke pemain.</p>
                </div>
            </li>
            <li>
                <span class="qik-step-no">3</span>
                <div>
                    <h3 class="h5">Mainkan dan lihat leaderboard</h3>
                    <p class="mb-0">Pemain menjawab satu soal per layar. Jawaban dicek di server dan peringkat diperbarui.</p>
                </div>
            </li>
        </ol>
    </div>
    </section>

<!-- FITUR: dibagi per peran, bukan tiga kartu identik -->
    <section class="py-5 qik-section-alt" id="fitur">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-6">
                <h2 class="qik-h2">Untuk host</h2>
                <ul class="qik-list mt-3">
                    <li>Buat, ubah, dan hapus kuis serta soalnya</li>
                    <li>Atur batas waktu untuk setiap soal</li>
                    <li>Soal dan opsi diacak supaya tiap pemain beda urutan</li>
                    <li>Lihat leaderboard dan riwayat kuis yang pernah dibuat</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="qik-h2">Untuk pemain</h2>
                <ul class="qik-list mt-3">
                    <li>Masuk hanya dengan kode room dan nama panggilan</li>
                    <li>Satu soal per layar, nyaman di ponsel</li>
                    <li>Pantau posisimu di leaderboard room</li>
                    <li>Punya akun? Riwayat pengerjaanmu tersimpan</li>
                </ul>
            </div>
        </div>
    </div>
    </section>

<!-- CTA penutup -->
    <section class="py-5 qik-cta">
    <div class="qik-daftar container text-center">
        <h2 class="qik-h2 text-white mb-3">Siap bikin kuis pertamamu?</h2>
        <a class="btn" href="<?= url('auth/register.php') ?>">Daftar gratis</a>
    </div>
</section>
</body>
</html>


@include('includes.footer')
