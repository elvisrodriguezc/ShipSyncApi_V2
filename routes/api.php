<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\CandidateController as Candidate;
use App\Http\Controllers\Api\CompanyController as Company;
use App\Http\Controllers\Api\UserController as User;
use App\Http\Controllers\Api\BallotController as Ballot;

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
    Route::apiResource('candidates', Candidate::class);
    Route::apiResource('users', User::class);
    Route::apiResource('ballots', Ballot::class);
});
