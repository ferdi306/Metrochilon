-- SOLUSI SEDERHANA: Hapus database dan buat ulang
-- Jalankan di phpMyAdmin

-- Hapus database jika ada
DROP DATABASE IF EXISTS `metrochilon`;

-- Buat database baru
CREATE DATABASE `metrochilon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Pilih database
USE `metrochilon`;

-- Sekarang jalankan script create_all_tables.sql



