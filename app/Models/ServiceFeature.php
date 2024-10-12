<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFeature extends Model
{
    use HasFactory;

    protected $table = 'service_features';

    protected $fillable = [
        'service_id',
        'title',
        'description',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
