<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'client_name', 'client_phone', 'scheduled_date', 'status', 'message'
    ];

    public function property()
{
    return $this->belongsTo(\App\Models\Property::class);
}

}

