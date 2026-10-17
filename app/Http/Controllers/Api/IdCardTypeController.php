<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IdCardType;
use Illuminate\Http\Request;

class IdCardTypeController extends Controller
{
    public function index()
    {
        $data = IdCardType::all();
        return response()->json([
            'data' => $data,
            'meta' => [
                'total' => $data->count(),
            ]
        ]);
    }
}
