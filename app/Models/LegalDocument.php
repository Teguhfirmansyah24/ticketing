<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'ktp_number',
        'ktp_file',
        'ktp_name',
        'ktp_address',
        'npwp_number',
        'npwp_file',
        'npwp_name',
        'npwp_address',
        'deed_number',
        'deed_file',
        'deed_name',
        'deed_address',
        'notes',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
