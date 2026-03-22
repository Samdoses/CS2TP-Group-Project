<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable  = ['rating', 'review_status',
    'review_image', 'review_text', 'review_date',
    'user_id', 'order_id', 'product_id', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime' ];
    //this is for the foreign keys (many to one)

    public function getStatusColour(): string
    {
        return match($this->review_status) {
            'Approved' => 'bg-green-100 text-green-800 border-green-200',
            'Pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'Rejected' => 'bg-red-100 text-red-800 border-red-200',
            default    => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
