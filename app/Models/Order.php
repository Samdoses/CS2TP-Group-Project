<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
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

    public function returns()
    {
        return $this->hasMany(ReturnOrder::class);
    }

    public function isReturnable(): bool
    {
        return in_array($this->order_status, ['Delivered', 'Partially Returned', 'Pending Partial Return'], true);
    }

    public function isReviewable(): bool
    {
        return in_array($this->order_status, ['Delivered', 'Pending Partial Return', 'Pending Full Return', 'Partially Returned', 'Fully Returned'], true);
    }

    public function isCancellable(): bool
    {
        return in_array($this->order_status, ['Pending', 'Placed', 'Packed'], true);
    }

    public function getColourStatus()
    {
        return match($this->order_status) {
            'Packed' => 'bg-violet-600 text-white',
            'Delivered' => 'bg-emerald-500 text-white',
            'Shipped' => 'bg-blue-500 text-white',
            'Out for Delivery' => 'bg-sky-600 text-white',
            'Pending Full Return' => 'bg-orange-500 text-white',
            'Pending Partial Return' => 'bg-amber-500 text-white',
            'Partially Returned' => 'bg-cyan-600 text-white',
            'Fully Returned' => 'bg-slate-600 text-white',
            'Cancelled' => 'bg-red-600 text-white',
            'Refunded' => 'bg-rose-600 text-white',
            default => 'bg-indigo-600 text-white',
        };
    }

}
