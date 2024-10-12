<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_log';
    protected $fillable = [
        'booking_id',
        'action',
        'user_ip',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
