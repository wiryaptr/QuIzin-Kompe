<?php
// includes/header.php
// Pakai di halaman: set $pageTitle dan $activeNav sebelum require.
require_once __DIR__ . '/config.php';

$pageTitle = $pageTitle ?? APP_NAME;
$activeNav = $activeNav ?? '';

// Menandai link menu yang sedang aktif (dibaca screen reader & diberi garis bawah)
function aria_current(string $key, string $current): string
{
    return $key === $current ? ' aria-current="page"' : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | <?= e(APP_NAME) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Font brand & menu dari Figma: tambahkan family-nya di URL ini, lalu isi --qh-font-brand / --qh-font-nav di style.css -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark qh-navbar sticky-top">
    <div class="container">

        <!-- Brand: kertas abu + krem di belakang (statis), label oranye di depan (beranimasi) -->
        <a class="qh-brand-link" href="<?= url() ?>">
            <span class="qh-brand-paper qh-brand-paper--back" aria-hidden="true"></span>
            <span class="qh-brand-paper qh-brand-paper--cream" aria-hidden="true"></span>
            <span class="qh-brand-label"><?= e(APP_NAME) ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav"
                aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="qh-paper-link qh-paper-link--amber" href="<?= url() ?>"<?= aria_current('home', $activeNav) ?>>Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="qh-paper-link qh-paper-link--green" href="<?= url('#cara-main') ?>">Cara Main</a>
                </li>
                <li class="nav-item">
                    <a class="qh-paper-link qh-paper-link--purple" href="<?= url('#fitur') ?>">Fitur</a>
                </li>
            </ul>

            <div class="qh-nav-actions">
                <?php if (is_logged_in()): ?>
                    <span class="qh-btn-wrap qh-btn-wrap--paper">
                        <a class="qh-paper-btn" href="<?= url('dashboard/index.php') ?>">Dashboard</a>
                    </span>
                    <span class="qh-btn-wrap">
                        <a class="qh-paper-btn" href="<?= url('auth/logout.php') ?>">Keluar</a>
                    </span>
                <?php else: ?>
                    <span class="qh-btn-wrap qh-btn-wrap--paper">
                        <a class="qh-paper-btn" href="<?= url('auth/login.php') ?>"<?= aria_current('login', $activeNav) ?>>Masuk</a>
                    </span>
                    <span class="qh-btn-wrap">
                        <a class="qh-paper-btn" href="<?= url('auth/register.php') ?>"<?= aria_current('register', $activeNav) ?>>Daftar</a>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow-1">
