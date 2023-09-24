<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'entity_id',
        'cashier_id',
        'currency_id',
        'table_id',
        'tariff_id',
        'number',
        'pax',
        'discount_percent',
        'total',
        'status',
        'user_id',
    ];
    protected $cast = [];
    public static function boot()
    {
        parent::boot();

        self::creating(function ($order) {
            // ... code here
        });

        self::created(function ($order) {
            // ... code here
        });

        self::updating(function ($order) {
            // ... code here
        });

        self::updated(function ($order) {
            // dd($orderItems[0]->attributes['tariffitem_id']);
            if ($order->status === 11) {
                $orderItems = Orderitem::where('order_id', $order->id)->where('status', 1)->get();
                // dd($orderItems);
                // Separar los items de la orden por almacén
                $itemsByWarehouse = [];
                foreach ($orderItems as $item) {
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
                $order->item()->update(['status' => 11]);
            }
        });

        self::deleting(function ($order) {
            // ... code here
        });

        self::deleted(function ($model) {
            // ... code here
        });
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }
    public function orderitem()
    {
        return $this->hasMany(Orderitem::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
