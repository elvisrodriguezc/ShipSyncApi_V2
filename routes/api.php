<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\CarController as CarV1;
use App\Http\Controllers\Api\CompanyController as CompanyV1;
use App\Http\Controllers\Api\CategoryController as CategoryV1;
use App\Http\Controllers\Api\EntityController as EntityV1;
use App\Http\Controllers\Api\HeadquarterController as HeadquarterV1;
use App\Http\Controllers\Api\PayrollafpController as PayrollafpV1;
use App\Http\Controllers\Api\ProductController as ProductV1;
use App\Http\Controllers\Api\ProgramationController as ProgramationV1;
use App\Http\Controllers\Api\TypeController as TypeV1;
use App\Http\Controllers\Api\TypevalueController as TypevalueV1;
use App\Http\Controllers\Api\UbigeodepartamentoController as UbigeodepartamentoV1;
use App\Http\Controllers\Api\UbigeodistritoController as UbigeodistritoV1;
use App\Http\Controllers\Api\UbigeoprovinciaController as UbigeoprovinciaV1;
use App\Http\Controllers\Api\UserController as UserV1;
use App\Http\Controllers\Api\WarehouseController as WarehouseV1;
use App\Http\Controllers\Api\RoleController as RoleV1;

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
    Route::get('/user', function (Request $request) {
        // $user = new UserResource($request->user());
        // $data = $user->resolve(); // Convertir el recurso en un array
        // return  response()->json($data);
        return $request->user();
    });
    Route::apiResource('cars', CarV1::class);
    Route::apiResource('categories', CategoryV1::class);
    Route::apiResource('companies', CompanyV1::class);
    Route::apiResource('departments', UbigeodepartamentoV1::class);
    Route::apiResource('districts', UbigeodistritoV1::class);
    Route::apiResource('entities', EntityV1::class);
    Route::apiResource('headquarters', HeadquarterV1::class);
    Route::apiResource('payrollafps', PayrollafpV1::class);
    Route::apiResource('products', ProductV1::class);
    Route::apiResource('programations', ProgramationV1::class);
    Route::apiResource('provinces', UbigeoprovinciaV1::class);
    Route::apiResource('types', TypeV1::class);
    Route::apiResource('typevalues', TypevalueV1::class);
    Route::apiResource('users', UserV1::class);
    Route::put('/users/changepassword/{user}', [UserV1::class, 'changePassword']);
    Route::apiResource('warehouses', WarehouseV1::class);
    Route::apiResource('roles', RoleV1::class);
});
