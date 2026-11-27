<?php
// auth/register.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../database/koneksi.php';

if (is_logged_in()) {
    redirect(url());
}

$errors = [];
$old    = ['name' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['password_confirm'] ?? '';
    $old      = ['name' => $name, 'email' => $email];

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Formulir kedaluwarsa. Muat ulang halaman lalu coba lagi.';
    }
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
        $errors[] = 'Nama harus 2 sampai 100 karakter.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 255) {
        $errors[] = 'Format email tidak valid.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Kata sandi minimal 8 karakter.';
    } elseif (strlen($password) > 72) {
        $errors[] = 'Kata sandi maksimal 72 karakter.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Konfirmasi kata sandi tidak sama.';
    }

    if (!$errors) {
        try {
            $check = db()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            $check->execute([$email]);

            if ($check->fetch()) {
                $errors[] = 'Email ini sudah terdaftar. Silakan masuk.';
            } else {
                $insert = db()->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
                $insert->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);

                flash_set('Akun berhasil dibuat. Silakan masuk.');
                redirect(url('auth/login.php'));
            }
        } catch (PDOException $ex) {
            // 23000 = email dobel (dua pendaftaran bersamaan); selain itu error server
            $errors[] = $ex->getCode() === '23000'
                ? 'Email ini sudah terdaftar. Silakan masuk.'
                : 'Terjadi kesalahan di server. Pastikan database sudah di-import.';
        }
    }
}

$pageTitle = 'Daftar';
$activeNav = 'register';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="qh-auth">
    <div class="container">
        <div class="qh-auth-card">
            <h1 class="h3 qh-display mb-1">Buat akun</h1>
            <p class="text-body-secondary mb-4">Akun dibutuhkan untuk membuat kuis dan menjadi host. Untuk bermain, cukup kode room.</p>

            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= url('auth/register.php') ?>" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control form-control-lg" id="name" name="name"
                           value="<?= e($old['name']) ?>" maxlength="100" autocomplete="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email"
                           value="<?= e($old['email']) ?>" maxlength="255" autocomplete="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata sandi</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password"
                           minlength="8" maxlength="72" autocomplete="new-password" aria-describedby="passwordHelp" required>
                    <div id="passwordHelp" class="form-text">Minimal 8 karakter.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label">Ulangi kata sandi</label>
                    <input type="password" class="form-control form-control-lg" id="password_confirm" name="password_confirm"
                           maxlength="72" autocomplete="new-password" required>
                </div>

                <button type="submit" class="btn btn-ink btn-lg w-100">Daftar</button>
            </form>

            <p class="text-center mt-4 mb-0">
                Sudah punya akun? <a href="<?= url('auth/login.php') ?>">Masuk</a>
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
