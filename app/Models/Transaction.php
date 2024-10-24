<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class , 'booking_id');
    }

}
