<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable  = ['category_name','category_description'];

    //this is for the foreign keys (one to many)
    public function products() {
        return $this->hasMany(Product::class);
    }
}
