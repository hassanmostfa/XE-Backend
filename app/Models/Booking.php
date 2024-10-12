<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'service_id',
        'notes',
        'payment_status',
        'payment_gate',
        'booking_status',
    ];  

    
}
