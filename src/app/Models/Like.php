<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'seeking_id'];

    //ユーザーへのリレーション
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    //募集へのリレーション
    public function seeking()
    {
        return $this->belongsTo('App\Models\Seeking');
    }
}
