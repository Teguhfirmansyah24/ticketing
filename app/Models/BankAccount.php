<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'branch',
        'city',
        'is_primary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
