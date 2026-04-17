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
        // CSR-CON-T1 Seed Data
        $conItems = [
            [
                'item_name' => 'Surgical Scissors',
                'unit' => 'pc',
                'ideal_stocks' => 50,
                'total_stock' => 50,
                'supply_on_hand' => 45,
                'location' => 'CSR CABINET 1A',
                'item_condition' => 'Good',
            ],
            [
                'item_name' => 'Cotton Swabs',
                'unit' => 'pack',
                'ideal_stocks' => 100,
                'total_stock' => 100,
                'supply_on_hand' => 80,
                'location' => 'CSR CABINET 2A',
                'item_condition' => 'New',
                'expiration_date' => '2026-12-31',
            ],
            [
                'item_name' => 'Gauze Pads',
                'unit' => 'box',
                'ideal_stocks' => 80,
                'total_stock' => 75,
                'supply_on_hand' => 70,
                'location' => 'CSR CABINET 1A',
                'item_condition' => 'Good',
            ]
        ];

        foreach ($conItems as $item) {
            CsrConT1::create($item);
        }

        // CSR-NCON-T1 Seed Data
        $nconItems = [
            [
                'item_name' => 'Wheelchair',
                'unit' => 'unit',
                'ideal_stocks' => 10,
                'total_stock' => 10,
                'supply_on_hand' => 8,
                'location' => 'CSR CABINET 3A',
                'item_condition' => 'Good',
            ],
            [
                'item_name' => 'Stethoscope',
                'unit' => 'pc',
                'ideal_stocks' => 30,
                'total_stock' => 30,
                'supply_on_hand' => 25,
                'location' => 'CSR CABINET 4A',
                'item_condition' => 'New',
            ]
        ];

        foreach ($nconItems as $item) {
            CsrNconT1::create($item);
        }
    }
}
