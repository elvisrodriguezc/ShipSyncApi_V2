<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\V1\BrandController as V1Brand;
use App\Http\Controllers\Api\V1\CashierController as V1Cashier;
use App\Http\Controllers\Api\V1\CashierdetailController as V1CashierDet;
use App\Http\Controllers\Api\V1\CategoryController as V1Category;
use App\Http\Controllers\Api\V1\CompanyCompleteController;
use App\Http\Controllers\Api\V1\CompanyController as V1Company;
use App\Http\Controllers\Api\V1\CurrencyController as V1Currency;
use App\Http\Controllers\Api\V1\EntityController as V1Entity;
use App\Http\Controllers\Api\V1\UnityController as V1Unity;
use App\Http\Controllers\Api\V1\UserController as V1User;
use App\Http\Controllers\Api\V1\UbigeodepartamentoController as V1UDpto;
use App\Http\Controllers\Api\V1\UbigeoprovinciaController as V1UProv;
use App\Http\Controllers\Api\V1\UbigeodistritoController as V1UDist;
use App\Http\Controllers\Api\V1\OfficeController as V1Office;
use App\Http\Controllers\Api\V1\OrderController as V1Order;
use App\Http\Controllers\Api\V1\OrderitemController as V1Orderitem;
use App\Http\Controllers\Api\V1\PaymethodController as V1Paymet;
use App\Http\Controllers\Api\V1\ProductController as V1Product;
use App\Http\Controllers\Api\V1\PurchaseController as V1Purchase;
use App\Http\Controllers\Api\V1\PurchaseitemController as V1Purchaseitem;
use App\Http\Controllers\Api\V1\SunatrucController as V1Sunatruc;
use App\Http\Controllers\Api\V1\TableController as V1Table;
use App\Http\Controllers\Api\V1\TariffController as V1Tariff;
use App\Http\Controllers\Api\V1\TariffitemController as V1Tariffitem;
use App\Http\Controllers\Api\V1\TaxmodeController as V1Taxmodes;
use App\Http\Controllers\Api\V1\WarehouseController as V1Warehouse;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);


Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/brands', V1Brand::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/cashiers', V1Cashier::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/cashierdetails', V1CashierDet::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('/cashieropen', [V1Cashier::class, 'cashierSelectActive']);

    Route::apiResource('/categories', V1Category::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/companies', V1Company::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::patch('/companies/{company}/complete', CompanyCompleteController::class);

    Route::apiResource('/currencies', V1Currency::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/entities', V1Entity::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/entities', V1Entity::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('/entities/find/{idFormNumber}', [V1Entity::class, 'searchByIdFormNumber']);

    Route::apiResource('/unities', V1Unity::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/paymethods', V1Paymet::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/products', V1Product::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/ubigeodptos', V1UDpto::class)
        ->only(['index', 'show']);
    Route::apiResource('/ubigeoprovs', V1UProv::class)
        ->only(['index', 'show']);
    Route::apiResource('/ubigeodists', V1UDist::class)
        ->only(['index', 'show']);
    Route::apiResource('/offices', V1Office::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/orders', V1Order::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/orderitems', V1Orderitem::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/purchases', V1Purchase::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/purchaseitems', V1Purchaseitem::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/sunatrucs', V1Sunatruc::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::get('/sunatrucs/findruc/{ruc}', [V1Sunatruc::class, 'searchByRuc']);
    Route::get('/sunatrucs/findruc/{razon}', [V1Sunatruc::class, 'searchByRazon']);
    Route::get('/sunatrucs/findruc/{nombre}', [V1Sunatruc::class, 'searchByNombre']);

    Route::apiResource('/tables', V1Table::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/tariffs', V1Tariff::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/tariffitems', V1Tariffitem::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/taxmodes', V1Taxmodes::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::apiResource('/warehouses', V1Warehouse::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});
