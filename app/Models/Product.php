<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'product_model',
        'product_price',
        'product_part',
        'product_description',
        'product_tagline',
        'product_image',
        'product_createdate',
        'product_stock',
        'product_colour',
        'category_id',
    ];

    // this is for the foreign keys (many to one)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function specs()
    {
        return $this->hasMany(ProductSpec::class);
    }
}
