<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable  = ['product_name',
    'product_model', 'product_price', 'product_description',
    'product_thumbnail', 'product_image', 'product_createdate',
    'product_stock', 'category_id'];

    //this is for the foreign keys (many to one)
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
