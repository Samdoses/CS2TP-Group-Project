<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'return_date',
        'reason',
        'admin_comment',
        'admin_processed_at',
        'return_status',
        'return_quantity',
        'product_id',
        'order_id',
        'user_id',
        'stock_restored',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'return_date' => 'datetime',
        'created_at' => 'datetime',
        'admin_processed_at' => 'datetime',
        'stock_restored' => 'boolean',
    ];

    public static function getPendingQty($orderId, $productId)
    {
        return self::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->where('return_status', 'Processing')
            ->sum('return_quantity');
    }

    public static function getReturnedQty($orderId, $productId)
    {
        return self::where('order_id', $orderId)
            ->where('product_id', $productId)
            ->where('return_status', 'Approved')
            ->sum('return_quantity');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
