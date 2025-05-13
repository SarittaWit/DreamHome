<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'price',
        'status',
        'image', 
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
