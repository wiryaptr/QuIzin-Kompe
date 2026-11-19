# QuizHoodie

Aplikasi kuis interaktif berbasis web, terinspirasi dari Quizizz/Wayground. Pengguna yang login bisa membuat kuis dan menghostnya di sebuah room, sedangkan guest cukup memasukkan kode room dan nama panggilan untuk ikut bermain.

Proyek akhir mata kuliah Pemrograman Berbasis Platform (PBP).

## Fitur Utama

- Register, login, dan logout (login Google opsional)
- Buat, edit, dan hapus kuis dan soal (pilihan ganda, 4 opsi, batas waktu per soal)
- Host membuka room dari kuis dan mendapat kode room
- Guest masuk room dengan kode dan nama panggilan, tanpa akun
- Lobby dan status room
- Mengerjakan kuis satu soal per layar, jawaban dicek di server
- Soal dan opsi diacak
- Leaderboard per room
- Riwayat kuis yang dibuat dan riwayat pengerjaan
- Statistik soal yang paling sering salah (opsional)

## Teknologi

- Frontend: HTML, CSS, JavaScript, Bootstrap, Blade
- Backend: Laravel [12]
- Database: MariaDB / MySQL
- PHP: [8.2+]

## Cara Menjalankan

Prasyarat: PHP [8.2+], Composer, MariaDB/MySQL, dan Git.

- Windows: Laragon
- macOS: Laravel Herd + DBngin

1. Clone repo

```powershell
git clone https://github.com/[username]/quizhoodie.git
```

2. Masuk ke folder proyek

```powershell
cd quizhoodie
```

3. Pasang dependency

```powershell
composer install
```

4. Salin file konfigurasi, lalu sesuaikan isi `.env` (nama database `quizhoodie`)

```powershell
copy .env.example .env
```

5. Buat database kosong bernama `quizhoodie` lewat HeidiSQL atau TablePlus

6. Buat application key

```powershell
php artisan key:generate
```

7. Jalankan migration dan seeder

```powershell
php artisan migrate --seed
```

8. Jalankan aplikasi. Dengan Laragon buka `http://quizhoodie.test`, atau pakai:

```powershell
php artisan serve
```

Di macOS, perintah `copy` diganti `cp .env.example .env`.

## Alur Kerja Tim

- `main` hanya berisi kode yang berjalan
- Setiap fitur dikerjakan di branch baru: `fitur/nama-fitur`
- Fitur selesai: buka Pull Request ke `main`, di-review satu anggota lain, lalu merge

## Screenshot

[Menyusul]

## Tim

| Nama | Peran |
|---|---|
| [Arya Wirya Putra Jatmiko] | Backend 1 |
| [Muhammad Afifudin Zain] | Backend 2 |
| [Mirza Fadhil Naufal] | Frontend 1 |
| [Felix Nathaniel Naldo Pradhana] | Frontend 2 |