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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    
}
