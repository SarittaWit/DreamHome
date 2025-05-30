<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_url',
        'phone',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'agent_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'agent_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'agent_id')->where('read', false);
    }

}
