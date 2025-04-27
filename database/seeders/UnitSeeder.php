<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Unit::create([
            'company_id' => 1,
            'name' => 'Unidad',
            'symbol' => 'Und',
            'value' => 1,
            'status' => 1,
        ]);

        \App\Models\Unit::create([
            'company_id' => 1,
            'name' => 'Kilogramo',
            'symbol' => 'Kg',
            'value' => 1,
            'status' => 1,
        ]);

        \App\Models\Unit::create([
            'company_id' => 1,
            'name' => 'Ltr',
            'symbol' => 'Ltr',
            'value' => 1,
            'status' => 1,
        ]);
        \App\Models\Unit::create([
            'company_id' => 1,
            'name' => 'Gramo',
            'symbol' => 'Gr',
            'value' => 0.001,
            'status' => 1,
        ]);
        \App\Models\Unit::create([
            'company_id' => 1,
            'name' => 'Mililitro',
            'symbol' => 'Ml',
            'value' => 0.001,
            'status' => 1,
        ]);
    }
}
