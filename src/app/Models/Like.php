<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable =['user_id','seeking_id'];

    //ユーザーへのリレーション
    public function users(){
      return $this->belongsTo('App\User');
    }

    //募集へのリレーション
    public function ideas(){
        return $this->belongsTo('App\Seeking');
    }
}
