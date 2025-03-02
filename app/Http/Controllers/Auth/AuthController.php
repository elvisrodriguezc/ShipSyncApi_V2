<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'document' => 'required|string',
        ]);

        $user = User::where('document', $request->document)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Las Credeciales no son correctas',
                'Error' => 1,
            ], 401);
        }

        function remove_accents($string)
        {
            $unwanted_array = array(
                'á' => 'a',
                'é' => 'e',
                'í' => 'i',
                'ó' => 'o',
                'ú' => 'u',
                'Á' => 'A',
                'É' => 'E',
                'Í' => 'I',
                'Ó' => 'O',
                'Ú' => 'U',
                'ä' => 'a',
                'ë' => 'e',
                'ï' => 'i',
                'ö' => 'o',
                'ü' => 'u',
                'Ä' => 'A',
                'Ë' => 'E',
                'Ï' => 'I',
                'Ö' => 'O',
                'Ü' => 'U',
                'à' => 'a',
                'è' => 'e',
                'ì' => 'i',
                'ò' => 'o',
                'ù' => 'u',
                'À' => 'A',
                'È' => 'E',
                'Ì' => 'I',
                'Ò' => 'O',
                'Ù' => 'U'
            );
            return strtr($string, $unwanted_array);
        }

        $exist = collect(explode(' ', $request->name))->every(function ($nameWord) use ($user) {
            return collect(explode(' ', $user->name))->contains(function ($userWord) use ($nameWord) {
                return strtolower(remove_accents($userWord)) === strtolower(remove_accents($nameWord));
            });
        });

        if (!$exist) {
            return response()->json([
                'message' => 'Las Credeciales no son correctas',
                'Error' => 1,
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Token eliminado correctamente',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'document' => 'required|string',
            'company_id' => 'required|integer',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'document' => $request->document,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
