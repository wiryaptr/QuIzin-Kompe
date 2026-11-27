<?php
// includes/config.php
// Dipanggil paling awal di setiap halaman: require_once __DIR__ . '/includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Quizin Kompe');

// Folder proyek di htdocs. Kalau foldernya C:\xampp\htdocs\quizhoodie, isi '/quizhoodie'.
// Kalau nanti dipasang di root virtual host, isi ''.
define('BASE_URL', '/quizhoodie');

// Helper: escape output supaya aman dari XSS
function e(?string $text): string
{
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

// Helper: URL absolut dalam proyek, contoh: url('auth/login.php')
function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

// Helper: cek status login (sesuaikan dengan cara login nanti)
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

// Helper: pindah halaman lalu hentikan script
function redirect(string $to): void
{
    header('Location: ' . $to);
    exit;
}

// Helper: pesan sekali tampil (flash), dipakai setelah register berhasil
function flash_set(string $message): void
{
    $_SESSION['flash'] = $message;
}

function flash_get(): ?string
{
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}

// Helper: CSRF token untuk setiap form POST
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function csrf_verify(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
