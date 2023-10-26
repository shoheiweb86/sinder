<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Connection;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function seekings()
    {
        return $this->hasMany(Seeking::class, 'user_id');
    }

    public function likes_from_users()
    {
        return $this->hasMany(Like::class, 'like_from_user_id');
    }

    public function likes_to_users()
    {
        return $this->hasMany(Like::class, 'like_to_user_id');
    }
}
