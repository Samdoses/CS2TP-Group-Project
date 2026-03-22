<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'sender_name',
        'sender_email',
        'contact_reason',
        'related_order_id',
        'subject',
        'message',
        'admin_read_at',
        'admin_reply',
        'admin_replied_at',
        'customer_seen_reply',
    ];

    protected $casts = [
        'admin_read_at' => 'datetime',
        'admin_replied_at' => 'datetime',
        'customer_seen_reply' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'related_order_id');
    }
}
