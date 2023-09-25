<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Company::factory(2)->create();
        \App\Models\User::factory()->create([
            'company_id' => 1,
            'name' => 'Elvis Rodríguez',
            'email' => 'elvisrodriguezc@gmail.com',
            'password' => Hash::make('password')
        ]);
        \App\Models\User::factory()->create([
            'company_id' => 2,
            'name' => 'Yeny Lilian',
            'email' => 'yeeerequita@gmail.com',
            'password' => Hash::make('password')
        ]);
        \App\Models\User::factory()->create([
            'company_id' => 2,
            'name' => 'Julio Enrique',
            'email' => 'julio@gmail.com',
            'password' => Hash::make('password')
        ]);
        \App\Models\Currency::factory()->create([
            'name' => 'PEN',
            'symbol' => 'S/',
            'rate' => 0
        ]);
        \App\Models\Currency::factory()->create([
            'name' => 'USD',
            'symbol' => '$',
            'rate' => 0
        ]);
        \App\Models\Unity::factory()->create([
            'company_id' => 2,
            'name' => 'Unidad',
            'abbreviation' => 'Und',
            'value' => 1,
            'status' => 1
        ]);
        \App\Models\Unity::factory()->create([
            'company_id' => 1,
            'name' => 'Unidad',
            'abbreviation' => 'Und',
            'value' => 1,
            'status' => 1
        ]);
        \App\Models\Unity::factory()->create([
            'company_id' => 2,
            'name' => 'Docena',
            'abbreviation' => 'Dc',
            'value' => 12,
            'status' => 1
        ]);
        \App\Models\Brand::factory(5)->create();
        \App\Models\Ubigeodepartamento::factory(20)->create();
        \App\Models\Ubigeoprovincia::factory(50)->create();
        \App\Models\Ubigeodistrito::factory(120)->create();
        \App\Models\Office::factory()->create([
            'company_id' => 2,
            'name' => 'Unidad',
            'address' => 2,
            'phone' => "084-256555",
            'email' => "groend@gmail.com",
            'ubigeodistrito_id' => 2
        ]);
        \App\Models\Office::factory(3)->create();
        \App\Models\Warehouse::factory(6)->create();
        \App\Models\Category::factory(8)->create();
        \App\Models\Taxmode::factory()->create([
            'name' => 'Gravado',
            'code' => '001',
        ]);
        \App\Models\Taxmode::factory()->create([
            'name' => 'Exonerado',
            'code' => '002',
        ]);
        \App\Models\Taxmode::factory()->create([
            'name' => 'Inafecto',
            'code' => '003',
        ]);
        \App\Models\Unspsc::factory()->create([
            'name' => '--',
            'type' => 'default',
            'code' => '0',
        ]);
        \App\Models\Unspsc::factory(10)->create();
        \App\Models\Product::factory(35)->create();
        \App\Models\Tariff::factory()->create([
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Usuario',
            'rate' => 20,
        ]);
        \App\Models\Tariff::factory()->create([
            'company_id' => 1,
            'office_id' => 1,
            'name' => 'Distribuidor',
            'rate' => 15,
        ]);
        \App\Models\Tariff::factory()->create([
            'company_id' => 2,
            'office_id' => 1,
            'name' => 'Usuario',
            'rate' => 15,
        ]);
        \App\Models\Tariffitem::factory(50)->create();
        \App\Models\Table::factory(6)->create();
        \App\Models\Cashier::factory(2)->create();
        \App\Models\Idform::factory()->create([
            'name' => 'DNIdentidad',
            'abbrev' => 'DNI',
        ]);
        \App\Models\Idform::factory()->create([
            'name' => 'RUContribuyente',
            'abbrev' => 'RUC',
        ]);
        \App\Models\Idform::factory()->create([
            'name' => 'Pasaporte',
            'abbrev' => 'PAS',
        ]);
        \App\Models\Entity::factory(4)->create();
        \App\Models\Receipttype::factory()->create([
            'name' => 'Nota de Venta',
            'abbrev' => 'NV',
            'code' => '015'
        ]);
        \App\Models\Receipttype::factory()->create([
            'name' => 'Factura',
            'abbrev' => 'FV',
            'code' => '001'
        ]);
        \App\Models\Receipttype::factory()->create([
            'name' => 'Boleta',
            'abbrev' => 'BV',
            'code' => '008'
        ]);
        \App\Models\Receipttype::factory()->create([
            'name' => 'Guia de Remision',
            'abbrev' => 'BV',
            'code' => '005'
        ]);
        \App\Models\Receipttype::factory()->create([
            'name' => 'Nota de Crédito',
            'abbrev' => 'NC',
            'code' => '004'
        ]);
        \App\Models\Receipttype::factory()->create([
            'name' => 'Nota de Débito',
            'abbrev' => 'ND',
            'code' => '003'
        ]);
        \App\Models\Order::factory(2)->create();
        \App\Models\Orderitem::factory(10)->create();
        \App\Models\Purchase::factory(4)->create();
        \App\Models\Purchaseitem::factory(12)->create();
    }
}
