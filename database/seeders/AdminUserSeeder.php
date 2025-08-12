<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create super admin user if not exists
        User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@fisika-medis.ac.id',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        // Create regular admin user if not exists
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@fisika-medis.ac.id',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        echo "Seeder completed!\n";
        echo "Super Admin - Username: superadmin, Password: superadmin123\n";
        echo "Regular Admin - Username: admin, Password: admin123\n";
    }
}
