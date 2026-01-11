-- SOLUSI: Hapus database dan buat ulang
-- Jalankan di phpMyAdmin (pilih database lain dulu, misal 'mysql')

-- Hapus database metrochilon (akan menghapus semua tablespace juga)
DROP DATABASE IF EXISTS `metrochilon`;

-- Buat database baru
CREATE DATABASE `metrochilon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Setelah ini, jalankan: php artisan migrate



