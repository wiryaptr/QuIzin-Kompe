<?php
// auth/login.php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../database/koneksi.php';

if (is_logged_in()) {
    redirect(url());
}

$errors = [];
$email  = '';
$notice = flash_get();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Formulir kedaluwarsa. Muat ulang halaman lalu coba lagi.';
    } elseif ($email === '' || $password === '') {
        $errors[] = 'Isi email dan kata sandi.';
    } else {
        try {
            $stmt = db()->prepare('SELECT id, name, password FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Ganti ID sesi setelah login untuk mencegah session fixation
                session_regenerate_id(true);
                $_SESSION['user_id']   = (int) $user['id'];
                $_SESSION['user_name'] = $user['name'];

                // Ganti ke url('dashboard/index.php') kalau halaman dashboard sudah ada
                redirect(url());
            }

            // Pesan sengaja sama untuk email salah maupun sandi salah
            $errors[] = 'Email atau kata sandi salah.';
        } catch (PDOException $ex) {
            $errors[] = 'Terjadi kesalahan di server. Pastikan database sudah di-import.';
        }
    }
}

$pageTitle = 'Masuk';
$activeNav = 'login';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="qh-auth">
    <div class="container">
        <div class="qh-auth-card">
            <h1 class="h3 qh-display mb-1">Masuk</h1>
            <p class="text-body-secondary mb-4">Masuk untuk membuat kuis dan membuka room.</p>

            <?php if ($notice): ?>
                <div class="alert alert-success" role="status"><?= e($notice) ?></div>
            <?php endif; ?>

            <?php if ($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= e($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= url('auth/login.php') ?>" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email"
                           value="<?= e($email) ?>" maxlength="255" autocomplete="email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Kata sandi</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password"
                           maxlength="72" autocomplete="current-password" required>
                </div>

                <button type="submit" class="btn btn-ink btn-lg w-100">Masuk</button>
            </form>

            <p class="text-center mt-4 mb-1">
                Belum punya akun? <a href="<?= url('auth/register.php') ?>">Daftar</a>
            </p>
            <p class="text-center small text-body-secondary mb-0">
                Hanya ingin bermain? Masukkan kode room di <a href="<?= url() ?>">beranda</a>.
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
