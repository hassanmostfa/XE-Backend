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
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function service()
    {
        return $this->hasMany(ServiceFeature::class);
    }

}
