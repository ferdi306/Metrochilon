<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user (idempotent)
        User::updateOrCreate([
            'email' => 'adminmpg@example.com'
        ], [
            'name' => 'Admin Metrochilon',
            'password' => Hash::make('metrochilon11!'),
            'role' => 'admin',
            'must_change_password' => false,
        ]);
    }
}
