<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'role',
        'password',
        'avatar',
        'phone',
        'birth_date',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'birth_date'        => 'date',
        ];
    }

    // ==================
    // Helper Role
    // ==================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ==================
    // Relasi sebagai Creator
    // ==================

    // Event yang dibuat oleh user ini
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // ==================
    // Relasi sebagai Buyer
    // ==================

    // Order yang dilakukan oleh user ini
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Tiket yang dimiliki oleh user ini
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    // ==================
    // Relasi sebagai Validator
    // ==================

    // Validasi tiket yang dilakukan oleh user ini (admin/creator)
    public function ticketValidations()
    {
        return $this->hasMany(TicketValidation::class, 'validated_by');
    }

    // Payment yang diverifikasi oleh user ini (admin)
    public function verifiedPayments()
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }
}
