<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Category;
use App\Models\Company;
use App\Models\Document;
use App\Models\Entity;
use App\Models\Headquarter;
use App\Models\Numerator;
use App\Models\Payrollafp;
use App\Models\Product;
use App\Models\Type;
use App\Models\Typevalue;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */



    public function run(): void
    {
        Company::factory(2)->create();
        Headquarter::factory(4)->create();
        Payrollafp::factory(2)->create();
        Type::factory()->create(
            [
                'company_id' => 1,
                'name' => 'Tipo de Documento',
                'description' => 'Tipos de documentos de identidad',
            ]
        );
        Type::factory()->create(
            [
                'company_id' => 1,
                'name' => 'Servicios',
                'description' => 'Tipos de Servicios',
            ]
        );
        Typevalue::factory()->create(
            [
                'type_id' => 2,
                'name' => 'Reparto',
                'description' => 'Reparto de mercadería',
                'abbreviation' => 'DNI'
            ]
        );
        Typevalue::factory()->create(
            [
                'type_id' => 2,
                'name' => 'Edificio',
                'description' => 'Traslado de mercadería a edificio',
                'abbreviation' => 'RUC'
            ]
        );
        Typevalue::factory()->create(
            [
                'type_id' => 1,
                'name' => 'DNI',
                'description' => 'Documento Nacional de Identidad',
                'abbreviation' => 'DNI'
            ]
        );
        Typevalue::factory()->create(
            [
                'type_id' => 1,
                'name' => 'RUC',
                'description' => 'Registro Único de Contribuyentes',
                'abbreviation' => 'RUC'
            ]
        );
        Typevalue::factory()->create(
            [
                'type_id' => 1,
                'name' => 'CE',
                'description' => 'Carnet de Extranjería',
                'abbreviation' => 'CE'
            ]
        );

        User::factory()->create(
            [
                'company_id' => 1,
                'headquarter_id' => 1,
                'first_name' => 'Elvis',
                'last_name' => 'Rodríguez Cornejo',
                'username' => 'elvisrodriguezc',
                'role' => 'sadmin',
                'document_id' => 1,
                'document_number' => '12345678',
                'phone' => '987654321',
                'address' => 'Av. Los Alamos 123',
                'email' => 'elvisrodriguezc@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'license' => '1234567890',
                'licencecategory' => 'A1',
                'isAF' => 1,
                'isAFP' => 1,
                'payrollafp_id' => 1,
                'salary' => 2000,
                'additionalpay' => 200,
            ]
        );
        User::factory(3)->create();
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'BOL',
                'name' => 'Boleta',
            ]
        );
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'FAC',
                'name' => 'Factura',
            ]
        );
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'GRR',
                'name' => 'Guía de Remisión Remitente',
            ]
        );
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'GRT',
                'name' => 'Guía de Remisión Trastransportista',
            ]
        );
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'PRG',
                'name' => 'Programación de Carga',
            ]
        );
        Document::factory()->create(
            [
                'headquarter_id' => 1,
                'code' => 'SRV',
                'name' => 'Servicio de Transporte',
            ]
        );
        Numerator::factory(4)->create();
        Category::factory(6)->create();
        Product::factory(20)->create();
        Entity::factory()->create(
            [
                "id" => 2,
                "company_id" => 1,
                "mode" => "C",
                "ruc" => "20100128056",
                "razon_social" => "SAGA FALABELLA S A",
                "estado" => "ACTIVO",
                "condicion" => "HABIDO",
                "ubigeo" => "150131",
                "tipo_via" => "AV.",
                "nombre_via" => "PASEO DE LA REPUBLICA",
                "codigo_zona" => "URB.",
                "tipo_zona" => "JARDIN",
                "numero" => "3220",
                "interior" => "-",
                "lote" => "-",
                "departamento" => "-",
                "manzana" => "-",
                "kilometro" => "-",
            ]
        );
        Entity::factory()->create(

            [
                "id" => 1,
                "company_id" => 1,
                "mode" => "C",
                "ruc" => "20337564373",
                "razon_social" => "TIENDAS POR DEPARTAMENTO RIPLEY S.A.C.",
                "estado" => "ACTIVO",
                "condicion" => "HABIDO",
                "ubigeo" => "150131",
                "tipo_via" => "AV.",
                "nombre_via" => "LAS BEGONIAS",
                "codigo_zona" => "URB.",
                "tipo_zona" => "JARDIN",
                "numero" => "545",
                "interior" => "-",
                "lote" => "-",
                "departamento" => "-",
                "manzana" => "-",
                "kilometro" => "-",
            ]
        );
        Car::factory(10)->create();
    }
}
