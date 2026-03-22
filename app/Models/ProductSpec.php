<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'spec_key',
        'spec_value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
