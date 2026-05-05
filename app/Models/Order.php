<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'order_code',
        'total_amount',
        'status',
        'name',
        'email',
        'phone',
        'id_number',
        'snap_token',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
        'total_amount' => 'integer',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function event() { return $this->belongsTo(Event::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
}