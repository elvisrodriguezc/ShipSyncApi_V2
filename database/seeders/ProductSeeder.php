<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Pollo Carne S/M',
            'codigo' => 'POLLO-CS',
            'description' => 'Pollo carne sin Menudencia',
            'peso' => 150,
            'vida_util' => 7,
            'image' => 'https://example.com/image1.jpg',
            'unit_id' => 2,
            'price' => 10.00,
            'stock' => 100,
        ]);

        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Pollo Carne C/M',
            'description' => 'Pollo carne con Menudencia',
            'image' => 'https://example.com/image2.jpg',
            'unit_id' => 2,
            'price' => 20.00,
            'stock' => 50,
        ]);

        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Pollo Brasa 1.76',
            'description' => 'Pollo a la brasa con ensalada',
            'image' => 'https://example.com/image3.jpg',
            'unit_id' => 1,
            'price' => 30.00,
            'stock' => 75,
        ]);
        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Cerdo',
            'description' => 'Pollo Brasa 1.38 ',
            'image' => 'https://example.com/image4.jpg',
            'unit_id' => 1,
            'price' => 40.00,
            'stock' => 25,
        ]);
        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Pavo Redondos',
            'description' => 'Carne de Pavo Redondos',
            'image' => 'https://example.com/image5.jpg',
            'unit_id' => 2,
            'price' => 50.00,
            'stock' => 10,
        ]);
        \App\Models\Product::create([
            'company_id' => 1,
            'category_id' => 1,
            'name' => 'Pavo',
            'description' => 'Lechón Redondos',
            'image' => 'https://example.com/image6.jpg',
            'unit_id' => 2,
            'price' => 60.00,
            'stock' => 5,
        ]);
    }
}
