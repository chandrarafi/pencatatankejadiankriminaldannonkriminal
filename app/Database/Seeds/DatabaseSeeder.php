<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "=== Database Seeding Started ===\n\n";

        // Jalankan seeder untuk users
        $this->call('UserSeeder');

        // Jalankan seeder untuk anggota
        $this->call('AnggotaSeeder');

        echo "\n=== Database Seeding Completed ===\n";
        echo "✅ Semua data default berhasil di-seed!\n";
        echo "📝 Aplikasi siap digunakan dengan akun default.\n\n";
    }
}
