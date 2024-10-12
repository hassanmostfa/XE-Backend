<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    
    protected $fillable = [
        'country_id',
        'title',
        'description',
        'price',
        'image'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function features()
    {
        return $this->hasMany(ServiceFeature::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
