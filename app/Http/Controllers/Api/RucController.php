<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RucController extends Controller
{
    public function search($ruc)
    {
        $url = env('DNIRUC_URL');
        $token = env('DNIRUC_TOKEN');

        if (!$url || !$token) {
            return response()->json([
                'error' => true,
                'message' => 'DNIRUC_URL o DNIRUC_TOKEN no configurados'
            ], 500);
        }

        try {
            $response = Http::withToken($token)
                ->get("{$url}ruc/{$ruc}");

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'error' => true,
                'message' => 'Error al consultar RUC',
                'details' => $response->body()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
