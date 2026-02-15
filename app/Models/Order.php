<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable  = ['order_address',
    'total_price', 'delivery_method','order_date', 'order_status',
    'user_id'];

    protected $casts = [
        'order_date' =>'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class);
    }

}
