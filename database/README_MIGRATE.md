# Cara Reset Database dan Migrate Ulang

## Masalah
Tablespace MySQL masih tersisa meskipun tabel sudah dihapus, menyebabkan error saat membuat tabel baru.

## Solusi

### Opsi 1: Hapus Database di phpMyAdmin (DISARANKAN)
1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Klik database `metrochilon` di sidebar kiri
3. Klik tab "Operations"
4. Scroll ke bagian "Remove database"
5. Centang "Drop the database (DROP)"
6. Klik "Go" dan konfirmasi
7. Buat database baru dengan nama `metrochilon`
8. Jalankan: `php artisan migrate`

### Opsi 2: Gunakan SQL Script
Jalankan di phpMyAdmin (pilih database lain dulu):
```sql
DROP DATABASE IF EXISTS `metrochilon`;
CREATE DATABASE `metrochilon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Kemudian jalankan:
```bash
php artisan migrate
```

### Opsi 3: Restart MySQL Service
Jika masih error:
1. Buka XAMPP Control Panel
2. Stop MySQL
3. Start MySQL
4. Coba migrate lagi

## Setelah Migrate Berhasil
Semua tabel akan dibuat otomatis:
- users
- attendances
- location_pings
- attendance_settings
- leaves
- migrations
- cache, jobs, sessions, dll



