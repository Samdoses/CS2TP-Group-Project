<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_price',
        'quantity',
        'delivery_status',
        'order_id',
        'product_id',
        'created_at',
        'updated_at',
    ];

    //we use booted here and static creating to make sure whenever a new product is created for an order
    //it will always take the delivery_status corresponding to its parent order
    //this is important for the seeding being synced to the admin pages
    protected static function booted()
    {
        static::creating(function ($orderDetail) {
            if ($orderDetail->order) {
                $orderDetail->delivery_status = $orderDetail->order->order_status;
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
