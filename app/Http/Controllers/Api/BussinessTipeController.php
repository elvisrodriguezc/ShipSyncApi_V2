<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BussinessTipeResource;
use App\Models\BussinessTipe;
use Illuminate\Http\Request;

class BussinessTipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $types = BussinessTipe::where('company_id', $company_id)
            ->where('status', 1)
            ->orderby('name', 'asc')
            ->get();
        return BussinessTipeResource::collection($types);
    }
}
