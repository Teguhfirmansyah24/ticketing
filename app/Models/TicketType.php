<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quota',
        'sold',
        'is_active',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function availableQuota()
    {
        // Sisa stok yang benar-benar bisa dibeli
        return $this->quota - $this->sold;
    }

    public function hasAvailableStock($quantity)
    {
        return $this->availableQuota() >= $quantity;
    }
}
