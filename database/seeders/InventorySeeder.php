<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CsrConT1;
use App\Models\CsrNconT1;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CsrConT1::factory(50)->create();
        \App\Models\CsrNconT1::factory(50)->create();
        \App\Models\BorrowLog::factory(50)->create();
    }
}
