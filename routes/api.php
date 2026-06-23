<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\CarController as CarV1;
use App\Http\Controllers\Api\CategoryController as CategoryV1;
use App\Http\Controllers\Api\CompanyController as CompanyV1;
use App\Http\Controllers\Api\ContactController as ContactV1;
use App\Http\Controllers\Api\EntityController as EntityV1;
use App\Http\Controllers\Api\HeadquarterController as HeadquarterV1;
use App\Http\Controllers\Api\OrderformController as OrderformV1;
use App\Http\Controllers\Api\OrderformitemController as OrderformitemV1;
use App\Http\Controllers\Api\PermissionController as PermissionV1;
use App\Http\Controllers\Api\ProductController as ProductV1;
use App\Http\Controllers\Api\ProgramationController as ProgramationV1;
use App\Http\Controllers\Api\RoleController as RoleV1;
use App\Http\Controllers\Api\TypeController as TypeV1;
use App\Http\Controllers\Api\TypevalueController as TypevalueV1;
use App\Http\Controllers\Api\UbigeodepartamentoController as UbigeodepartamentoV1;
use App\Http\Controllers\Api\UbigeoprovinciaController as UbigeoprovinciaV1;
use App\Http\Controllers\Api\UbigeodistritoController as UbigeodistritoV1;
use App\Http\Controllers\Api\UnitController as UnitV1;
use App\Http\Controllers\Api\UserController as UserV1;
use App\Http\Controllers\Api\BussinessTipeController as BussinessTipeV1;
use App\Http\Controllers\Api\PurchaseController as PurchaseV1;
use App\Http\Controllers\Api\WarehouseController as WarehouseV1;
use App\Http\Controllers\Api\DocumentController as DocumentV1;
use App\Http\Controllers\Api\BatchController as BatchV1;
use App\Http\Controllers\Api\MovimientoInventarioController as MovimientoInventarioV1;
use App\Http\Controllers\Api\RucController as RucV1;
use App\Http\Controllers\Api\StockReportController as StockReportV1;

use Illuminate\Support\Facades\Artisan;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

// Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/linkbuilder', function () {
        Artisan::call('storage:link');
        return 'Enlace simbólico creado correctamente.';
    });
    Route::get('/clearcache', function () {
        Artisan::call('cache:clear');
        return 'Cache eliminada correctamente.';
    });
    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return 'Migración ejecutada correctamente.';
    });
    Route::get('/migratefresh', function () {
        Artisan::call('migrate:fresh');
        return 'Migración ejecutada correctamente.';
    });
    Route::get('/user', [AuthController::class, 'user']);
    Route::apiResource('cars', CarV1::class);
    Route::apiResource('categories', CategoryV1::class);
    Route::apiResource('companies', CompanyV1::class);
    Route::apiResource('departments', UbigeodepartamentoV1::class);
    Route::apiResource('districts', UbigeodistritoV1::class);
    Route::apiResource('entities', EntityV1::class);
    Route::apiResource('headquarters', HeadquarterV1::class);
    Route::apiResource('products', ProductV1::class);
    Route::apiResource('programations', ProgramationV1::class);
    Route::apiResource('provinces', UbigeoprovinciaV1::class);
    Route::apiResource('types', TypeV1::class);
    Route::apiResource('typevalues', TypevalueV1::class);
    Route::apiResource('cars', CarV1::class);
    Route::apiResource('headquarters', HeadquarterV1::class);
    Route::apiResource('departments', UbigeodepartamentoV1::class);
    Route::apiResource('provinces', UbigeoprovinciaV1::class);
    Route::apiResource('districts', UbigeodistritoV1::class);
    Route::post('orderforms/{orderform}/approve', [App\Http\Controllers\Api\OrderformController::class, 'approve']);
    Route::post('orderforms/{orderform}/attend', [App\Http\Controllers\Api\OrderformController::class, 'attend']);
    Route::apiResource('orderforms', OrderformV1::class);
    Route::apiResource('orderformitems', OrderformitemV1::class);
    Route::apiResource('roles', RoleV1::class);
    Route::get('/roles/{role}/menus', [App\Http\Controllers\Api\MenuController::class, 'getRoleMenus']);
    Route::post('/roles/{role}/menus', [App\Http\Controllers\Api\MenuController::class, 'assignMenusToRole']);
    Route::get('/user/menu', [App\Http\Controllers\Api\MenuController::class, 'userMenu']);
    Route::apiResource('menus', App\Http\Controllers\Api\MenuController::class);
    Route::apiResource('units', UnitV1::class);
    Route::put('/users/changepassword/{id}', [UserV1::class, 'changePassword']);
    Route::apiResource('users', UserV1::class);
    Route::apiResource('suggestions', App\Http\Controllers\Api\SuggestionController::class);
    Route::apiResource('helps', App\Http\Controllers\Api\HelpController::class);
    Route::apiResource('permissions', PermissionV1::class);
    Route::apiResource('contacts', ContactV1::class);
    Route::apiResource('bussiness_tipes', BussinessTipeV1::class);
    Route::post('purchases/{purchase}/receive', [App\Http\Controllers\Api\PurchaseController::class, 'receive']);
    Route::apiResource('purchases', PurchaseV1::class);
    Route::apiResource('warehouses', WarehouseV1::class);
    Route::apiResource('documents', DocumentV1::class);
    Route::apiResource('batches', BatchV1::class);
    Route::apiResource('movimientos-inventario', MovimientoInventarioV1::class);
    Route::get('ruc/{ruc}', [RucV1::class, 'search']);
    Route::get('reports/stock', [StockReportV1::class, 'index']);
});
