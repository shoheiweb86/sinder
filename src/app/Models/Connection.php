<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seeking;

class Connection extends Model
{
    protected $fillable = [
        'user_id_1',
        'user_id_2',
        'seeking_id',
        'connection_date',
    ];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user_id_1');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

    public function seeking()
    {
        return $this->belongsTo(Seeking::class, 'seeking_id');
    }
}
