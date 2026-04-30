<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketValidation extends Model
{
    protected $fillable = [
        'ticket_id',
        'validated_by',
        'validated_at',
        'note',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
