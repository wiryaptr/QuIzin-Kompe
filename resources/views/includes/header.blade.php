@php
    if (!function_exists('aria_current')) {
        function aria_current(string $current, ?string $active): string
        {
            return $current === $active ? ' aria-current="page"' : '';
        }
    }

    if (!function_exists('nav_active')) {
        function nav_active(string $key, string $current): string
        {
            return $key === $current ? ' active' : '';
        }
    }

    $appName = config('app.name', 'QuIzin Kompe');
    $pageTitle = $pageTitle ?? $appName;
    $activeNav = $activeNav ?? '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }} | {{ $appName }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark qik-navbar sticky-top">
    <div class="container">
        <a class="qik-brand-link" href="{{ url('/') }}">
            <span class="qik-brand-sheet qik-brand-sheet--back" aria-hidden="true"></span>
            <span class="qik-brand-sheet qik-brand-sheet--front" aria-hidden="true"></span>
            <span class="qik-brand-face">
                <span class="qik-brand-shape" aria-hidden="true"></span>
                <span class="qik-brand-text">{{ $appName }}</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav"
                aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>   

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="qik-paper-link qik-paper-link--weapon">
                        <span class="qik-link-shape"></span>
                        <a class="qik-link-text"{!! aria_current('home', $activeNav) !!} href="{{ url('/') }}">Beranda</a>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="qik-paper-link qik-paper-link--vitality">
                        <span class="qik-link-shape"></span>
                        <a class="qik-link-text" href="{{ url('/#cara-main') }}">Cara main</a>
                    </span>
                </li>
                <li class="nav-item">
                    <span class="qik-paper-link qik-paper-link--spirit">
                        <span class="qik-link-shape"></span>
                        <a class="qik-link-text" href="{{ url('/#fitur') }}">Fitur</a>
                    </span>
                </li>
            </ul>
            <div class="qik-navbar-actions">
                <span class="qik-actions-sheet" aria-hidden="true"></span>
                @auth
                    <span class="qik-btn-warp qik-btn-warp-left">
                        <span class="qik-btn-shape"></span>
                        <a class="qik-btn-text" href="{{ url('/dashboard') }}">Dashboard</a>
                    </span>
                    <span class="qik-btn-warp qik-btn-warp-right">
                        <span class="qik-btn-shape"></span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 d-inline">
                            @csrf
                            <button type="submit" class="qik-btn-text border-0 bg-transparent">Keluar</button>
                        </form>
                    </span>
                @else
                    <span class="qik-btn-warp qik-btn-warp-left">
                        <span class="qik-btn-shape"></span>
                        <a class="qik-btn-text"{!! aria_current('login', $activeNav) !!} href="{{ url('/login') }}">Masuk</a>
                    </span>
                    <span class="qik-btn-warp qik-btn-warp-right">
                        <span class="qik-btn-shape"></span>  
                        <a class="qik-btn-text"{!! aria_current('register', $activeNav) !!} href="{{ url('/register') }}">Daftar</a>
                    </span>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow-1">