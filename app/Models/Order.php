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
        //makes sure the order this return request belongs to is delivered
        $validStatus = [
            'Delivered',
            'Shipped',
            'Partially Returned',
            'Pending Partial Return',
            'Pending Full Return'
        ];

        return in_array($this->order_status, $validStatus);
    }

    public function isCancellable(): bool
    {
    //make sure the order this return request belonds to is not shipped
    return $this->order_status === 'Placed';
    }

    public function getColourStatus()
    {
        return match($this->order_status) {
            'Delivered' => 'bg-emerald-500 text-white',
            'Shipped' => 'bg-blue-500 text-white',
            'Pending Full Return' => 'bg-orange-500 text-white',
            'Pending Partial Return' => 'bg-amber-500 text-white',
            'Partially Returned' => 'bg-cyan-600 text-white',
            'Fully Returned' => 'bg-slate-600 text-white',
            'Cancelled' => 'bg-red-600 text-white',
            default => 'bg-indigo-600 text-white',
        };
    }

    public function updateStatusBasedOnItems()
    {
        $items = $this->orderDetails;
        $totalCount = $items->count();
        $returnedCount = $items->where('delivery_status', 'Returned')->count();
        $pendingReturnCount = $items->where('delivery_status', 'Pending Return')->count();

        if ($returnedCount === $totalCount) {
            $status = 'Fully Returned';
        } elseif ($pendingReturnCount === $totalCount) {
            $status = 'Pending Full Return';
        } elseif ($returnedCount > 0 || $pendingReturnCount > 0) {
            //if there is a mix of returned/pending and normal items
            $status = ($pendingReturnCount > 0) ? 'Pending Partial Return' : 'Partially Returned';
        } else {
            $status = $this->order_status;
        }

        $this->update(['order_status' => $status]);
        return $status;
    }

}
