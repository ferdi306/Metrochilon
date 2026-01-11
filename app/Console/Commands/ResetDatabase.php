<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset {--force : Force reset without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset database: drop and recreate, then run migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('Apakah Anda yakin ingin menghapus semua tabel dan migrate ulang? Semua data akan hilang!')) {
                $this->info('Operasi dibatalkan.');
                return 0;
            }
        }

        $dbName = config('database.connections.mysql.database');
        $dbHost = config('database.connections.mysql.host');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        $this->info('Menghubungkan ke MySQL server...');

        try {
            // Koneksi ke database
            $dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $this->info("Menghapus semua tabel dan tablespace di database '{$dbName}'...");
            
            // Dapatkan semua tabel
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            
            if (!empty($tables)) {
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
                foreach ($tables as $table) {
                    $this->line("  Menghapus tabel: {$table}");
                    try {
                        // Coba discard tablespace dulu jika ada
                        $pdo->exec("ALTER TABLE `{$table}` DISCARD TABLESPACE");
                    } catch (PDOException $e) {
                        // Ignore jika tidak ada tablespace atau tabel tidak ada
                    }
                    $pdo->exec("DROP TABLE IF EXISTS `{$table}`");
                }
                $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                $this->info("✓ Semua tabel berhasil dihapus.");
            } else {
                $this->info("✓ Tidak ada tabel yang perlu dihapus.");
            }

            // Hapus file .ibd yang tersisa (tablespace files)
            $this->info("Membersihkan sisa tablespace...");
            $dataDir = $this->getMySQLDataDir();
            if ($dataDir && is_dir($dataDir . '/' . $dbName)) {
                $this->deleteIBDFiles($dataDir . '/' . $dbName);
            }

            $pdo = null;

            $this->info('Menjalankan migration...');
            
            // Jalankan migrate fresh
            $this->call('migrate:fresh', ['--force' => true]);

            $this->info('Membuat user sample...');
            
            // Buat user sample
            try {
                DB::table('users')->insert([
                    [
                        'name' => 'Admin',
                        'email' => 'admin@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'admin',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Karyawan',
                        'email' => 'karyawan@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'karyawan',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
                $this->info('✓ User sample berhasil dibuat.');
                $this->line('  - Admin: admin@example.com / password');
                $this->line('  - Karyawan: karyawan@example.com / password');
            } catch (\Exception $e) {
                $this->warn('Tidak bisa membuat user sample: ' . $e->getMessage());
            }

            $this->info('');
            $this->info('✓ Database berhasil direset dan migration selesai!');
            $this->info('✓ Semua tabel berhasil dibuat.');

            return 0;

        } catch (PDOException $e) {
            // Jika database tidak ada, buat dulu
            if (strpos($e->getMessage(), "Unknown database") !== false) {
                $this->info("Database '{$dbName}' tidak ada, membuat database baru...");
                
                try {
                    $dsn = "mysql:host={$dbHost};port={$dbPort};charset=utf8mb4";
                    $pdo = new PDO($dsn, $dbUser, $dbPass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    ]);
                    
                    $pdo->exec("CREATE DATABASE `{$dbName}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    $this->info("✓ Database '{$dbName}' berhasil dibuat.");
                    $pdo = null;
                    
                    // Jalankan migrate
                    $this->call('migrate', ['--force' => true]);
                    $this->info('✓ Migration selesai!');
                    return 0;
                } catch (PDOException $e2) {
                    $this->error('Error membuat database: ' . $e2->getMessage());
                    return 1;
                }
            }
            
            $this->error('Error: ' . $e->getMessage());
            $this->error('Pastikan MySQL server berjalan dan kredensial database benar.');
            return 1;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Get MySQL data directory path
     */
    private function getMySQLDataDir()
    {
        // Coba beberapa lokasi umum untuk XAMPP
        $possiblePaths = [
            'C:/xampp/mysql/data',
            'C:/Program Files/xampp/mysql/data',
            'C:/wamp64/bin/mysql/mysql8.0.31/data',
        ];

        foreach ($possiblePaths as $path) {
            if (is_dir($path)) {
                return $path;
            }
        }

        // Coba dapatkan dari MySQL
        try {
            $dbHost = config('database.connections.mysql.host');
            $dbPort = config('database.connections.mysql.port', '3306');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');
            
            $dsn = "mysql:host={$dbHost};port={$dbPort};charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            $result = $pdo->query("SHOW VARIABLES LIKE 'datadir'")->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['Value'])) {
                return str_replace('\\', '/', $result['Value']);
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }

    /**
     * Delete .ibd files (tablespace files)
     */
    private function deleteIBDFiles($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $files = glob($dir . '/*.ibd');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
                $this->line("  Menghapus file: " . basename($file));
            }
        }
    }
}
