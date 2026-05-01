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
        $user = User::firstOrCreate(
            ['email' => 'systemadmin@miis.com'], // Condition to check
            [
                // Data to insert if the email doesn't exist
                'name' => 'System Administrator',
                'password' => Hash::make('Admin123!'),
            ]
        );

        // Assign the admin role to the user
        $user->assignRole('System Admin');
    }
}
