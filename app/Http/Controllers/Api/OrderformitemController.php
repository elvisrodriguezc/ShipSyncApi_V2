<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderformitemRequest;
use App\Http\Resources\OrderformitemResource;
use App\Models\Orderformitem;
use Illuminate\Http\Request;

class OrderformitemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Orderformitem $orderformitem)
    {
        return OrderformitemResource::make($orderformitem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderformitemRequest $request, Orderformitem $orderformitem)
    {
        $request->validated();
        $orderformitem->update($request->all());
        $orderformitem->orderform()->update([
            'status' => 2,
        ]);
        if (isset($request->comment)) {
            if ($request->comment !== '') {
                $orderformitem->orderformitemcomments()->create([
                    'comment' => $request->comment,
                    'user_id' => auth()->user()->id,
                ]);
            }
        }
        return OrderformitemResource::make($orderformitem)->additional([
            'message' => 'Item de orden de pedido actualizado correctamente',
            'error' => 0,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orderformitem $orderformitem)
    {
        //
    }
}
