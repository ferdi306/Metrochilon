-- Script untuk membersihkan database dan siap untuk migrate ulang
-- Jalankan di phpMyAdmin pada database metrochilon

SET FOREIGN_KEY_CHECKS = 0;

-- Hapus semua tabel
DROP TABLE IF EXISTS `location_pings`;
DROP TABLE IF EXISTS `attendances`;
DROP TABLE IF EXISTS `attendance_settings`;
DROP TABLE IF EXISTS `leaves`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `migrations`;

SET FOREIGN_KEY_CHECKS = 1;

-- Setelah script ini dijalankan, jalankan: php artisan migrate



