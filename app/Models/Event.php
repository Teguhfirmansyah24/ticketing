<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'event_category_id',
        'title',
        'description',
        'location',
        'venue',
        'banner_image',
        'start_date',
        'end_date',
        'status',
        'contact_name',
        'contact_email',
        'contact_phone',
        'max_tickets_per_transaction',
        'one_email_one_transaction',
        'one_ticket_one_buyer',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
