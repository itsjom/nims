<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
<<<<<<< HEAD
            UserSeeder::class,
            // InventorySeeder::class,
=======
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            // UserSeeder::class,
            //InventorySeeder::class,
>>>>>>> 05213905c2a38bb7f6b717eb4003ef049142b558
        ]);
    }
}
