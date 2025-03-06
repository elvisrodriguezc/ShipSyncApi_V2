<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\CompanyController as Company;
use App\Http\Controllers\Api\UserController as User;
use App\Http\Controllers\Api\CategoryController as Category;
use App\Http\Controllers\Api\ProductController as Product;
use App\Http\Controllers\Api\ProgramationController as Programation;
use App\Http\Controllers\Api\EntityController as Entity;
use App\Http\Controllers\Api\TypeController as Type;
use App\Http\Controllers\Api\TypevalueController as Typevalue;
use App\Http\Controllers\Api\CarController as Car;

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
    Route::apiResource('companies', Company::class);
    Route::apiResource('users', User::class);
    Route::apiResource('categories', Category::class);
    Route::apiResource('products', Product::class);
    Route::apiResource('programations', Programation::class);
    Route::apiResource('entities', Entity::class);
    Route::apiResource('types', Type::class);
    Route::apiResource('typevalues', Typevalue::class);
    Route::apiResource('cars', Car::class);
});
