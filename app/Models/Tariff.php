<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tariff extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'name',
        'rate',
        'status',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function tariffitem()
    {
        return $this->hasMany(Tariffitem::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($tariff) {
            // ... code here
        });

        self::created(function ($tariff) {
            // $user = Auth::user();
            // $products = Product::where('set_mode', 'like', '%P%')
            //     ->where([
            //         ['status', '=', 1],
            //         ['company_id', '=', $user->company_id]
            //     ])
            //     ->get();
            // $warehouses = Warehouse::where('office_id', $tariff->office_id)
            //     ->get();
            // $warehouseFirst = $warehouses[0]->id;
            // foreach ($products as $product) {
            //     $tariffItem = new Tariffitem();
            //     $tariffItem->tariff_id = $tariff->id;
            //     $tariffItem->price = $product->price * (1 + ($tariff->rate / 100));
            //     $tariffItem->warehouse_id = $warehouseFirst;
            //     $tariffItem->product_id = $product->id;
            //     $tariffItem->currency_id = $product->currency_id;
            //     $tariffItem->status = 1;
            //     $tariffItem->save();
            // }
        });

        self::updating(function ($tariff) {
            // ... code here
        });

        self::updated(function ($tariff) {
            // dd($orderItems[0]->attributes['tariffitem_id']);
            if ($tariff->status === 11) {
                $tariffItems = Orderitem::where('order_id', $tariff->id)->where('status', 1)->get();
                // dd($tariffItems);
                // Separar los items de la orden por almacén
                $itemsByWarehouse = [];
                foreach ($tariffItems as $item) {
                    $tariffItemId = $item->attributes['tariffitem_id'];
                    $tariffItems = Tariffitem::where('id', $tariffItemId)->get();
                    $storeId = $tariffItems[0]->attributes['store_id'];
                    $itemsByWarehouse[$storeId][] = [
                        'store_id' => $storeId,
                        'orderitem_id' => $item->id,
                        'status' => $item->status
                    ];
                }
                // dd($itemsByWarehouse);
                // Crear un registro en la tabla Servicio por cada almacén
                $index = 0;
                // foreach ($itemsByWarehouse as $data) {
                //     // dd($data);
                //     $service = new Service();
                //     $service->company_id = $order->company_id;
                //     $service->order_id = $order->id;
                //     $service->store_id = $data[0]['store_id'];
                //     $service->status = 1;
                //     $service->save();
                //     foreach ($data as $item) {
                //         // dd($item);
                //         $serviceItem = new Serviceitem;
                //         $serviceItem->orderitem_id = $item['orderitem_id'];
                //         $service->serviceitems()->save($serviceItem);
                //     }
                // }
                // Want to Update the Items to 11 where it sent to service
                $tariff->item()->update(['status' => 11]);
            }
        });

        self::deleting(function ($tariff) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }
}
