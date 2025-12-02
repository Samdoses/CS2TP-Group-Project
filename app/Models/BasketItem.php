<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasketItem extends Model
{
    use HasFactory;

    protected $table = 'basket_items'; 
    
    // Allow multiple assignments for quantity, basket_id, and product_id
    protected $fillable = [
        'quantity',
        'basket_id',
        'product_id',
    ];
    
    protected $primaryKey = 'id'; 


     // A BasketItem belongs to one Basket.
    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    // 1 basket item belongs to 1 product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}