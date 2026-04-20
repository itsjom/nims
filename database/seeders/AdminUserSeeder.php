<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@nims.com'], // Condition to check
            [
                // Data to insert if the email doesn't exist
                'name' => 'System Administrator',
                'password' => Hash::make('Admin123!'),

                // If users table has an 'is_admin' or 'role' column, add it here:
                // 'is_admin' => true,
                // 'role' => 'admin',
            ]
        );
    }
}
