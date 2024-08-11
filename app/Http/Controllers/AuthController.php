<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $rememberme = true;

        if (!Auth::attempt($validated, $rememberme)) {
            return response()->json([
                'message' => 'Información de Acceso no Válidos',
                'name' => 'Login',
                'code' => 401
            ], 401);
        }

        // $request->session()->regenerate(); // Regenerar la sesión para prevenir fijación de sesión

        $user = Auth::user();

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
            'message' => 'El usuario accedió correctamente'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'company_id' => 'required',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create($validated);
        return response()->json([
            'data' => $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
            'message' => 'Registro Completado',
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'El usuario finalizo la sesión satisfactoriamente.'
        ], 200);
        // auth()->user()->tokens()->delete();
        // return response()->json([
        //     'status' => true,
        //     'message' => 'User logged out successfully'
        // ], 200);
    }
}
