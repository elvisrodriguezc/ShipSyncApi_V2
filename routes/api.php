<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Api\V1\VcandidateController as V1Vcandidate;

use Illuminate\Support\Facades\Artisan;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // $user = new UserResource($request->user());
    // $data = $user->resolve(); // Convertir el recurso en un array
    // return  response()->json($data);
    return $request->user();
});

Route::prefix('/v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/linkbuilder', function () {
        Artisan::call('storage:link');
        return 'Enlace simbólico creado correctamente.';
    });
});
