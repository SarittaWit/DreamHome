<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'role_id'];

    public function role()
    {
        return $this->belongsToMany(Permission::class);
    }

}
