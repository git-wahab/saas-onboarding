<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'card_number',
        'expiry',
        'phone',
    ];

    protected $hidden = [
        'card_number', // Hide card number from JSON serialization
    ];

    /**
     * Get the user that owns the billing information.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get masked card number for display
     */
    public function getMaskedCardNumberAttribute()
    {
        return '**** **** **** ' . substr($this->card_number, -4);
    }
}