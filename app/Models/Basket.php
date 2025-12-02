<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Basket extends Model
{
    use HasFactory;

    protected $table = 'baskets'; 
    
    protected $fillable = [
        'user_id', 
    ];

    /**
     * A Basket belongs to one User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Basket has many BasketItems.
     */
    public function items(): HasMany
    {
        // Links to the BasketItem Model
        return $this->hasMany(BasketItem::class);
    }
}