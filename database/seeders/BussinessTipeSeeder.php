<?php

namespace Database\Seeders;

use App\Models\BussinessTipe;
use Illuminate\Database\Seeder;

class BussinessTipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Pollería',
            'venta directa',
            'Pizzería',
            'restaurant',
            'fastfood'
        ];

        foreach ([1, 2] as $companyId) {
            foreach ($types as $type) {
                BussinessTipe::updateOrCreate([
                    'company_id' => $companyId,
                    'name' => $type,
                ], [
                    'status' => 1
                ]);
            }
        }
    }
}
